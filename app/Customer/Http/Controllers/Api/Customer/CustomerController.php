<?php

namespace App\Customer\Http\Controllers\Api\Customer;

use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\Payments\AccountPaymentType;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Accounting\Repositories\AccountingRepository;
use App\Customer\Models\Customer;
use App\Customer\Models\CustomerTerms;
use App\Customer\Repositories\CustomerRepository;
use App\Http\Controllers\Controller;
use App\helpers\HelperFunctions;
use App\Models\Account\Account;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Repositories\Practice\PracticeRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    protected $customers;
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $customer_terms;
    protected $payment_methods;
    protected $accountingVouchers;

    public function __construct( Customer $customers )
    {
        $this->customers = $customers;
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice());
        $this->customers = new CustomerRepository($customers);
        $this->customer_terms = new CustomerRepository(new CustomerTerms());
        $this->payment_methods = new AccountingRepository(new AccountPaymentType());
        $this->accountingVouchers = new AccountingRepository(new AccountsVoucher());
    }

    public function index(Request $request){

        $http_resp = $this->http_response['200'];
        $results = array();
        $company = $this->practices->find($request->user()->company_id);
        $customers = $company->customers()->orderByDesc('created_at')->paginate(10);
        $paged_data = $this->helper->paginator($customers);
        foreach($customers as $customer){
            array_push($results,$this->customers->transform_customer($customer) );
        }
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function create(Request $request){
        //Log::info($request);
        $http_resp = $this->http_response['200'];
        $rule = [
            'other_name'=>'required',
            'email'=>'required',
            'company'=>'required',
            'title'=>'required',
            'first_name'=>'required',
            'middle_name'=>'required',
            'address'=>'required',
            'postal_code'=>'required',
            'city'=>'required',
            'region'=>'required',
            'mobile'=>'required',
            'fax'=>'required',
            'payment_method_id'=>'required',
            'customer_term_id'=>'required',
        ];
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        //DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{
            $inputs = $request->all();
            $company = $this->practices->find($request->user()->company_id);
            $customer_term = $this->customer_terms->findByUuid($request->customer_term_id);
            $payment_method = $this->payment_methods->findByUuid($request->payment_method_id);
            if($customer_term){
                $inputs['customer_terms_id'] = $customer_term->id;
            }
            if($payment_method){
                $inputs['prefered_payment_id'] = $payment_method->id;
            }
            //Encode mobile number
            $encoded_mobile = $this->helper->encode_mobile($request->mobile,"KE");
            if(!$encoded_mobile){
                DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->rollBack();
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ['Invalid or missing mobile number!'];
                return response()->json($http_resp,422);
            }
            if( $company->customers()->where('mobile',$encoded_mobile)->get()->first() ){
                DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->rollBack();
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ['Mobile number already in use'];
                return response()->json($http_resp,422);
            }
            $inputs['mobile'] = $encoded_mobile;
            if( $company->customers()->where('email',$request->email)->get()->first() ){
                DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->rollBack();
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ['Email address already in use!'];
                return response()->json($http_resp,422);
            }
            $new_customer = $this->customers->create($inputs);//Create New Customer
            $new_customer = $company->customers()->save($new_customer);//Attach Customer to a company
            $ac_inputs = $request->all();
            $ac_inputs['name'] = $new_customer->first_name;
            $ac_inputs['account_type'] = Account::AC_CUSTOMERS;
            $account_holder = $new_customer->account_holders()->create($ac_inputs);//Create an account for this customer
            //Account is done here
            if($request->balance > 0){
                //Ensure start date is provided
                $rule2 = [
                    'as_of'=>'required',
                ];
                $validation = Validator::make($request->all(),$rule2,$this->helper->messages());
                if ($validation->fails()){
                    $http_resp = $this->http_response['422'];
                    $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                    return response()->json($http_resp,422);
                }
                $account_holder->balance = $request->balance;
                $account_holder->save(); //Update Account Holder Balance
                /*
                    Since we are creating new Customer with Opening balance:
                    1. Account Receivable is Debited
                    2. Sales Account Credited
                    3. Support Document is Invoice(Transaction Type)
                    4. AccountHolder: Balance is Increased
                */
                //Get Company Account Receivable
                $account_receivable = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_RECEIVABLE_CODE)->get()->first();
                //Get Company Sales Account
                $sales_account = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_SALES_CODE)->get()->first();
                $transaction_id = $this->helper->getToken(10);
                $double_entry = $this->accountingVouchers->accounts_double_entry($company,$account_receivable->code,$sales_account->code,$request->balance,$request->as_of,AccountsCoa::TRANS_TYPE_INVOICE,$transaction_id);
                $support_doc = $double_entry->support_documents()->create(['trans_type'=>AccountsCoa::TRANS_TYPE_INVOICE,'trans_name'=>$new_customer->title.' '.$new_customer->first_name]);
            }

            
        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->commit();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        return response()->json($http_resp);
    }
    public function update(Request $request,$uuid){}
    public function show($uuid){}
    public function delete($uuid){}
}

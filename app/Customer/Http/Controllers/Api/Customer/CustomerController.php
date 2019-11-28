<?php

namespace App\Customer\Http\Controllers\Api\Customer;

use App\Accounting\Models\COA\AccountChartAccount;
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
use App\Models\Localization\Country;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Models\Product\ProductTaxation;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
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
    protected $countries;
    protected $customer_terms;
    protected $payment_methods;
    protected $accountingVouchers;
    protected $taxations;
    //protected $paymentTerms;
    protected $accountChartAccount;

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
        $this->countries = new AccountingRepository( new Country() );
        $this->taxations = new ProductReposity( new ProductTaxation() );
        $this->accountChartAccount = new AccountingRepository(new AccountChartAccount());
        //$this->paymentTerms = new CustomerRepository(new CustomerTerms());
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

        Log::info($request);
        $http_resp = $this->http_response['200'];
        $rule = [
            'last_name'=>'required',
            'email'=>'required',
            //'company'=>'required',
            'salutation'=>'required',
            'first_name'=>'required',
            //'middle_name'=>'required',
            //'address'=>'required',
            //'postal_code'=>'required',
            //'city'=>'required',
            //'region'=>'required',
            'mobile'=>'required',
            'fax'=>'required',
            //'payment_method_id'=>'required',
            //'customer_term_id'=>'required',
            'display_as'=>'required',
            'credit_limit'=>'required',
            'cash_sale_customer'=>'required',
            'accept_electronic_invoices'=>'required',
            'old_invoice_receipt_auto_locate'=>'required',
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

            $inputs = $request->except(['payment_term_id']);
            $company = $this->practices->find($request->user()->company_id);
            //$customer_term = $this->customer_terms->findByUuid($request->customer_term_id);
            $payment_method = $this->payment_methods->findByUuid($request->payment_method_id);
            // if($customer_term){
            //     $inputs['customer_terms_id'] = $customer_term->id;
            // }
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
            if( $company->customers()->where('legal_name',$request->legal_name)->get()->first() ){
                DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->rollBack();
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ['Contact name already taken!'];
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
            if($request->vat_id){
                $tax = $this->taxations->findByUuid($request->vat_id);
                $inputs['default_vat_id'] = $tax->id;
            }

            if($request->vat_id){
                $tax = $this->taxations->findByUuid($request->vat_id);
                $inputs['default_vat_id'] = $tax->id;
            }

            $currecy = $this->countries->findByUuid($request->currency['id']);
            $inputs['currency_id'] = $currecy->id;
            $new_customer = $this->customers->create($inputs);//Create New Customer
            $new_customer = $company->customers()->save($new_customer);//Attach Customer to a company
            $ac_inputs = $request->all();
            $ac_inputs['name'] = $new_customer->first_name;
            $ac_inputs['account_type'] = Account::AC_CUSTOMERS;
            $ac_inputs['balance'] = 0;
            $ac_inputs['practice_id'] = $company->id;
            $ac_inputs['account_number'] = \strtoupper($this->helper->getToken(10,"CUST"));
            $account_holder = $new_customer->account_holders()->create($ac_inputs);//Create an account for this customer
            //Attach addresses to this account
            //Log::info($request);
            $bil_add = $request->billing;
            $ship_add = $request->shipping;
            if( $request->billing['country'] ){
                $country = $this->countries->findByUuid( $request->billing['country']['id'] );
                $bil_add['country_id'] = $country->id;
                $ship_add['country_id'] = $country->id;
            }
            $billing_address = $new_customer->addresses()->create($bil_add);
            $shipping_address = $new_customer->addresses()->create($ship_add);
            //Payment Terms
            if($request->payment_term_id){
                $pay_terms = $this->customer_terms->findByUuid($request->payment_term_id);
                $new_customer->payment_term_id = $pay_terms->id;
                $new_customer->save();
            }

            $main_parent = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_RECEIVABLE_CODE)->get()->first();
            $ac_inputs = $request->all();
            $ac_inputs['name'] = $request->legal_name;
            $custom_chart_of_coa = $this->accountChartAccount->create_sub_chart_of_account($company,$main_parent,$ac_inputs,$new_customer);

            //Account is done here
            if($request->opening_balance > 0){
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
                $amount = $request->opening_balance;
                $account_holder->balance = $amount;
                $account_holder->save(); //Update Account Holder Balance
                /*
                    Since we are creating new Customer with Opening balance:
                    1. Account Receivable is Debited
                    2. Sales Account Credited
                    3. Support Document is Invoice(Transaction Type)
                    4. AccountHolder: Balance is Increased
                */
                //Get Company Account Receivable
                //$account_receivable = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_RECEIVABLE_CODE)->get()->first();
                //Get Company Sales Account
                $sales_account = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_SALES_CODE)->get()->first();
                $transaction_id = $this->helper->getToken(10);
                $debited_ac = $custom_chart_of_coa->code;
                $credited_ac = $sales_account->code;
                $as_of = $request->as_of;
                $trans_type = AccountsCoa::TRANS_TYPE_CUSTOMER_OPENING_BALANCE;
                $trans_name = $request->display_as." ".$trans_type;
                $reference_number = AccountsCoa::TRANS_TYPE_OPENING_BALANCE;
                $account_number = $account_holder->account_number;
                $double_entry = $this->accountingVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_of,$trans_type,$transaction_id);
                $support_doc = $new_customer->double_entry_support_document()->create(['trans_type'=>$trans_type,'trans_name'=>$trans_name,'reference_number'=>$reference_number,'account_number'=>$account_number,'voucher_id'=>$double_entry->id]);
                //$support_doc = $double_entry->support_documents()->create(['trans_type'=>$trans_type,'trans_name'=>$trans_name,'reference_number'=>$reference_number,'account_number'=>$account_number]);
                //$support_doc = $new_customer->double_entry_support_document()->save($support_doc);
            }
            $http_resp['results'] = $this->customers->transform_customer($new_customer);

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

    // public function create(Request $request){
    //     //Log::info($request);
    //     $http_resp = $this->http_response['200'];
    //     $rule = [
    //         'other_name'=>'required',
    //         'email'=>'required',
    //         'company'=>'required',
    //         'title'=>'required',
    //         'first_name'=>'required',
    //         'middle_name'=>'required',
    //         'address'=>'required',
    //         'postal_code'=>'required',
    //         'city'=>'required',
    //         'region'=>'required',
    //         'mobile'=>'required',
    //         'fax'=>'required',
    //         'payment_method_id'=>'required',
    //         'customer_term_id'=>'required',
    //     ];
    //     $validation = Validator::make($request->all(),$rule,$this->helper->messages());
    //     if ($validation->fails()){
    //         $http_resp = $this->http_response['422'];
    //         $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
    //         return response()->json($http_resp,422);
    //     }

    //     //DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->beginTransaction();
    //     DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->beginTransaction();
    //     DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
    //     try{
    //         $inputs = $request->all();
    //         $company = $this->practices->find($request->user()->company_id);
    //         $customer_term = $this->customer_terms->findByUuid($request->customer_term_id);
    //         $payment_method = $this->payment_methods->findByUuid($request->payment_method_id);
    //         if($customer_term){
    //             $inputs['customer_terms_id'] = $customer_term->id;
    //         }
    //         if($payment_method){
    //             $inputs['prefered_payment_id'] = $payment_method->id;
    //         }
    //         //Encode mobile number
    //         $encoded_mobile = $this->helper->encode_mobile($request->mobile,"KE");
    //         if(!$encoded_mobile){
    //             DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->rollBack();
    //             DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
    //             $http_resp = $this->http_response['422'];
    //             $http_resp['errors'] = ['Invalid or missing mobile number!'];
    //             return response()->json($http_resp,422);
    //         }
    //         if( $company->customers()->where('mobile',$encoded_mobile)->get()->first() ){
    //             DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->rollBack();
    //             DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
    //             $http_resp = $this->http_response['422'];
    //             $http_resp['errors'] = ['Mobile number already in use'];
    //             return response()->json($http_resp,422);
    //         }
    //         $inputs['mobile'] = $encoded_mobile;
    //         if( $company->customers()->where('email',$request->email)->get()->first() ){
    //             DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->rollBack();
    //             DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
    //             $http_resp = $this->http_response['422'];
    //             $http_resp['errors'] = ['Email address already in use!'];
    //             return response()->json($http_resp,422);
    //         }
    //         $new_customer = $this->customers->create($inputs);//Create New Customer
    //         $new_customer = $company->customers()->save($new_customer);//Attach Customer to a company
    //         $ac_inputs = $request->all();
    //         $ac_inputs['name'] = $new_customer->first_name;
    //         $ac_inputs['account_type'] = Account::AC_CUSTOMERS;
    //         $account_holder = $new_customer->account_holders()->create($ac_inputs);//Create an account for this customer
    //         //Account is done here
    //         if($request->balance > 0){
    //             //Ensure start date is provided
    //             $rule2 = [
    //                 'as_of'=>'required',
    //             ];
    //             $validation = Validator::make($request->all(),$rule2,$this->helper->messages());
    //             if ($validation->fails()){
    //                 $http_resp = $this->http_response['422'];
    //                 $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
    //                 return response()->json($http_resp,422);
    //             }
    //             $account_holder->balance = $request->balance;
    //             $account_holder->save(); //Update Account Holder Balance
    //             /*
    //                 Since we are creating new Customer with Opening balance:
    //                 1. Account Receivable is Debited
    //                 2. Sales Account Credited
    //                 3. Support Document is Invoice(Transaction Type)
    //                 4. AccountHolder: Balance is Increased
    //             */
    //             //Get Company Account Receivable
    //             $account_receivable = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_RECEIVABLE_CODE)->get()->first();
    //             //Get Company Sales Account
    //             $sales_account = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_SALES_CODE)->get()->first();
    //             $transaction_id = $this->helper->getToken(10);
    //             $double_entry = $this->accountingVouchers->accounts_double_entry($company,$account_receivable->code,$sales_account->code,$request->balance,$request->as_of,AccountsCoa::TRANS_TYPE_INVOICE,$transaction_id);
    //             $support_doc = $double_entry->support_documents()->create(['trans_type'=>AccountsCoa::TRANS_TYPE_INVOICE,'trans_name'=>$new_customer->title.' '.$new_customer->first_name]);
    //         }

            
    //     }catch(\Exception $e){
    //         $http_resp = $this->http_response['500'];
    //         DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->rollBack();
    //         DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
    //         Log::info($e);
    //         return response()->json($http_resp,500);
    //     }
    //     DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->commit();
    //     DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
    //     return response()->json($http_resp);
    // }

    public function update(Request $request,$uuid){}
    public function show($uuid){}
    public function delete($uuid){}

    public function dashboard(Request $request){

        $http_resp = $this->http_response['200'];
        $company = $this->practices->find($request->user()->company_id);
        //Outstanding Balance
        $top_balance_customers = $company->account_holders()
            ->where('account_type',Account::AC_CUSTOMERS)
            ->orderByDesc('balance')
            ->paginate(10);
        $series = array();
        $labels = array();
        $chartOptions = array();
        foreach($top_balance_customers as $top_balance_customer){
            $balance = $top_balance_customer->balance;
            array_push($series,$balance);
            $customer_data = $top_balance_customer->owner()->get()->first();
            $customer_name = $customer_data->legal_name;
            array_push($labels,$customer_name);
        }
        $chartOptions['labels'] = $labels;
        $outstanding_balance['chartOptions'] = $chartOptions;
        $outstanding_balance['series'] = $series;

        //Days Balance is Outstanding
        $top_balance_customers = $company->account_holders()
        ->where('account_type',Account::AC_CUSTOMERS)
        ->orderBy('updated_at')
        ->paginate(10);

        $results['outstanding_balance'] = $outstanding_balance;
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }
}

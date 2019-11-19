<?php

namespace App\Supplier\Http\Controllers\Api\Vendor;

use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Accounting\Repositories\AccountingRepository as AppAccountingRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Practice\Practice;
use Illuminate\Support\Facades\Config;
use App\Repositories\Practice\PracticeRepository;
use App\Supplier\Models\Supplier;
use Illuminate\Support\Facades\Validator;
use App\helpers\HelperFunctions;
use App\Models\Account\Account;
use App\Models\Localization\Country;
use App\Models\Module\Module;
use App\Supplier\Models\SupplierCompany;
use App\Supplier\Models\SupplierTerms;
use App\Supplier\Repositories\SupplierRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VendorController extends Controller
{
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $suppliers;
    protected $accountingVouchers;
    protected $countries;
    protected $paymentTerms;
    protected $supplierCompanies;

    public function __construct()
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice() );
        $this->suppliers = new SupplierRepository( new Supplier() );
        $this->accountingVouchers = new AppAccountingRepository(new AccountsVoucher());
        $this->countries = new AppAccountingRepository( new Country() );
        $this->paymentTerms = new SupplierRepository( new SupplierTerms() );
        $this->supplierCompanies = new SupplierRepository( new SupplierCompany() );
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $results = array();
        $company = $this->practices->find($request->user()->company_id);
        $vendors = $company->vendors()->orderByDesc('created_at')->paginate(15);
        $paged_data = $this->helper->paginator($vendors);
        foreach( $vendors as $vendor){
            array_push($results, $this->suppliers->transform_supplier($vendor));
        }
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function create(Request $request){
        $http_resp = $this->http_response['200'];
        $rule = [
            'salutation'=>'required',
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required',
            'last_name'=>'required',
            'mobile'=>'required',
            'billing'=>'required',
            'shipping'=>'required',
            'currency'=>'required',
            'company'=>'required',
            'display_as'=>'required'
        ];
        //Log::info($request);
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{
            //
            $company = $this->practices->find($request->user()->company_id);
            //Check if email is already taken
            $inputs = $request->all();
            if( $company->vendors()->where('email',$request->email)->get()->first() ){
                DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ["Email address already in use"];
                return response()->json($http_resp,422);
            }
            //Check if mobile is already taken
            $encoded_mobile = $this->helper->encode_mobile($request->mobile,"KE");
            //
            if(!$encoded_mobile){
                DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ["Invalid or missing mobile number!"];
                return response()->json($http_resp,422);
            }
            //
            if( $company->vendors()->where('mobile',$encoded_mobile)->get()->first() ){
                DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ["Mobile already in use"];
                return response()->json($http_resp,422);
            }

            if( $company->vendors()->where('tax_reg_number',$request->tax_reg_number)->get()->first() ){
                DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ["Tax registration number already in use!"];
                return response()->json($http_resp,422);
            }

            //Get Vendor Company
            $vendor_company = $this->supplierCompanies->findByUuid($request->company);
            $inputs['company_id'] = $vendor_company->id;
            $inputs['mobile'] = $encoded_mobile;
            //Attach to currency
            $currecy = $this->countries->findByUuid($request->currency['id']);
            $inputs['currency_id'] = $currecy->id;
            //Create new vendor
            $new_vendor = $this->suppliers->create($inputs);
            //Attach this vendor to a company
            $new_vendor = $company->vendors()->save($new_vendor);
            //Attach this Vendor to Account
            $ac_inputs = $request->all();
            $ac_inputs['name'] = $new_vendor->first_name;
            $ac_inputs['account_type'] = Account::AC_SUPPLIERS;
            $ac_inputs['account_number'] = strtoupper($this->helper->getToken(10));
            $ac_inputs['balance'] = 0;
            $vendor_account = $new_vendor->account_holders()->create($ac_inputs);
            //Attach addresses to this account
            Log::info($request);
            $bil_add = $request->billing;
            $ship_add = $request->shipping;
            if( $request->billing['country'] ){
                $country = $this->countries->findByUuid( $request->billing['country']['id'] );
                $bil_add['country_id'] = $country->id;
                $ship_add['country_id'] = $country->id;
            }
            $billing_address = $new_vendor->addresses()->create($bil_add);
            $shipping_address = $new_vendor->addresses()->create($ship_add);
            //Payment Terms
            if($request->payment_term){
                $pay_terms = $this->paymentTerms->findByUuid($request->payment_term);
                $new_vendor->payment_term_id = $pay_terms->id;
                $new_vendor->save();
            }
            //Check if opening balance is given and save
            if($request->balance){
                $rule2 = [
                    'as_of'=>'required',
                ];
                $validation = Validator::make($request->all(),$rule2,$this->helper->messages());
                if ($validation->fails()){
                    $http_resp = $this->http_response['422'];
                    $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                    return response()->json($http_resp,422);
                }
                $vendor_account->balance = $request->balance;
                $vendor_account->save();//Update Account Holder Balance
                //Accounting Transactions starts here
                /*
                    Since we are creating supplier with Opening Balance:
                    1. Other Expense (Expense)
                    2. Account Payables (Liability) also increases
                    3. RULE: Asset & Expense have normal Debit Balance, Liability & Equity & Revenue have normal Credit Balance
                */
                //Get company Other Expense Account
                $other_expense = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_OTHER_EXPENSE)->get()->first();
                //Get company Accounts Payables
                $account_payables = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_PAYABLE_CODE)->get()->first();
                $transaction_id = $this->helper->getToken(10,'OPB');
                $double_entry = $this->accountingVouchers->accounts_double_entry($company,$other_expense->code,$account_payables->code,$request->balance,$request->as_of,AccountsCoa::TRANS_TYPE_OPENING_BALANCE,$transaction_id);
                $support_doc = $double_entry->support_documents()->create(['trans_type'=>AccountsCoa::TRANS_TYPE_OPENING_BALANCE,'trans_name'=>$new_vendor->salutation.' '.$new_vendor->first_name,'account_number'=>$vendor_account->account_number]);
                $http_resp['results'] = $this->suppliers->transform_supplier($new_vendor);
            }
            //
        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->commit();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        return response()->json($http_resp);
    }
    public function update(Request $request,$uuid){}

    public function show($uuid){
        $http_resp = $this->http_response['200'];
        $supplier = $this->suppliers->findByUuid($uuid);
        $http_resp['results'] = $this->suppliers->transform_supplier($supplier);
        return response()->json($http_resp);
    }

    public function delete($uuid){}

}

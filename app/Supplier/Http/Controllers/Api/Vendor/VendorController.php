<?php

namespace App\Supplier\Http\Controllers\Api\Vendor;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Accounting\Repositories\AccountingRepository;
use App\Finance\Models\Banks\AccountBankAccountType;
use App\Finance\Models\Banks\AccountMasterBank;
use App\Finance\Models\Banks\AccountMasterBankBranch;
use App\Finance\Models\Banks\AccountsBank;
use App\Finance\Repositories\FinanceRepository;
use App\Models\Practice\Taxation\PracticeTaxation;
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
use App\Models\Product\Product;
use App\Supplier\Models\SupplierCompany;
use App\Supplier\Models\SupplierTerms;
use App\Supplier\Repositories\SupplierRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Product\ProductReposity;
use App\Supplier\Models\SupplierAddress;
use Exception;

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
    protected $taxations;
    protected $banks;
    protected $bankBranches;
    protected $accountTypes;
    protected $accountChartAccount;
    protected $supplierAddresses;
    protected $bankAccounts;

    public function __construct()
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice() );
        $this->suppliers = new SupplierRepository( new Supplier() );
        $this->accountingVouchers = new AccountingRepository(new AccountsVoucher());
        $this->countries = new AccountingRepository( new Country() );
        $this->paymentTerms = new SupplierRepository( new SupplierTerms() );
        $this->supplierCompanies = new SupplierRepository( new SupplierCompany() );
        $this->taxations = new ProductReposity( new PracticeTaxation() );
        $this->banks = new FinanceRepository( new AccountMasterBank() );
        $this->bankBranches = new FinanceRepository( new AccountMasterBankBranch() );
        $this->accountTypes = new FinanceRepository( new AccountBankAccountType() );
        $this->accountChartAccount = new AccountingRepository(new AccountChartAccount());
        $this->supplierAddresses = new SupplierRepository( new SupplierAddress() );
        $this->bankAccounts = new FinanceRepository( new AccountsBank() );
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $results = array();
        $company = $this->practices->find($request->user()->company_id);
        $vendors = $company->vendors()->orderByDesc('created_at')->paginate(10);
        $paged_data = $this->helper->paginator($vendors);
        foreach( $vendors as $vendor){
            array_push($results, $this->suppliers->transform_supplier($vendor));
        }
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function create(Request $request){

        //Log::info($request);
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
            'currency_id'=>'required',
            'payment_term_id'=>'required',
            'display_as'=>'required',
            'credit_limit'=>'required',
            'default_discount'=>'required',
            'legal_name'=>'required',
            'bank_id'=>'required',
            'bank_branch_id'=>'required',
            'account_type_id'=>'required',
            'account_number'=>'required',
            'account_name'=>'required',
            'category'=>'required',
        ];
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        //
        $company = $this->practices->find($request->user()->company_id);
        //Check if email is already taken
        $inputs = $request->all();
        if( $company->vendors()->where('email',$request->email)->get()->first() ){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ["Email address already in use"];
            return response()->json($http_resp,422);
        }
        //Check if mobile is already taken
        $encoded_mobile = $this->helper->encode_mobile($request->mobile,"KE");
        //
        if(!$encoded_mobile){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ["Invalid or missing mobile number!"];
            return response()->json($http_resp,422);
        }
        //
        if( $company->vendors()->where('mobile',$encoded_mobile)->get()->first() ){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ["Mobile already in use"];
            return response()->json($http_resp,422);
        }

        if( $company->vendors()->where('tax_reg_number',$request->tax_reg_number)->get()->first() ){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ["Tax registration number already in use!"];
            return response()->json($http_resp,422);
        }

        if( $company->vendors()->where('legal_name',$request->legal_name)->get()->first() ){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ["Contact/Legal name already in use!"];
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{
            

            //Get Vendor Company
            // $vendor_company = $this->supplierCompanies->findByUuid($request->company);
            // $inputs['company_id'] = $vendor_company->id;
            // $inputs['mobile'] = $encoded_mobile;

            //Attach to currency
            $currecy = $this->countries->findByUuid($request->currency_id);
            if($currecy){
                $inputs['currency_id'] = $currecy->id;
            }
            //Attach Payment Terms
            $payment_term = $this->paymentTerms->findByUuid($request->payment_term_id);
            if($payment_term){
                $inputs['payment_term_id'] = $payment_term->id;
            }
            //Attach to VAT
            if($request->vat_id){
                $tax = $this->taxations->findByUuid($request->vat_id);
                $inputs['default_vat_id'] = $tax->id;
            }
            //Create new vendor
            $new_vendor = $this->suppliers->create($inputs);
            //Attach this vendor to a company
            $new_vendor = $company->vendors()->save($new_vendor);
            //Attach this Vendor to Account
            // $ac_inputs = $request->all();
            // $ac_inputs['name'] = $new_vendor->first_name;
            // $ac_inputs['account_type'] = Account::AC_SUPPLIERS;
            // $ac_inputs['account_number'] = strtoupper($this->helper->getToken(10));
            // $ac_inputs['balance'] = 0;
            // $ac_inputs['practice_id'] = $company->id;
            // $vendor_account = $new_vendor->account_holders()->create($ac_inputs);
            //Attach addresses to this account
            //Log::info($request);
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
            // if($request->payment_term){
            //     $pay_terms = $this->paymentTerms->findByUuid($request->payment_term);
            //     $new_vendor->payment_term_id = $pay_terms->id;
            //     $new_vendor->save();
            // }

            //Save Supplier Bank Account
            if($request->bank_id){
                $bank = $this->banks->findByUuid($request->bank_id);
                $inputs['bank_id'] = $bank->id;
            }
            if($request->bank_branch_id){
                $bank_branch = $this->bankBranches->findByUuid($request->bank_branch_id);
                $inputs['branch_id'] = $bank_branch->id;
            }
            if($request->account_type_id){
                $account_type = $this->accountTypes->findByUuid($request->account_type_id);
                $inputs['account_type_id'] = $account_type->id;
            }
            $inputs['balance'] = 0;
            $supplier_bank_account = $new_vendor->bank_accounts()->create($inputs);

            //Create Vendor Ledger Accounts
            $main_parent = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_PAYABLE_CODE)->get()->first();
            $ac_inputs = $request->all();
            $ac_inputs['name'] = $request->legal_name;
            $custom_chart_of_coa = $this->accountChartAccount->create_sub_chart_of_account($company,$main_parent,$ac_inputs,$new_vendor);

            //Check if opening balance is given and save
            if($request->opening_balance){

                $rule2 = [
                    'as_of'=>'required',
                ];
                $validation = Validator::make($request->all(),$rule2,$this->helper->messages());
                if ($validation->fails()){
                    $http_resp = $this->http_response['422'];
                    $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                    return response()->json($http_resp,422);
                }
                // $vendor_account->balance = $request->balance;
                // $vendor_account->save();//Update Account Holder Balance
                // $amount = $request->opening_balance;
                // $vendor_account->balance = $amount;
                // $vendor_account->save(); //Update Account Holder Balance
                //Accounting Transactions starts here
                /*
                    Since we are creating supplier with Opening Balance:
                    1. Other Expense (Expense)
                    2. Account Payables (Liability) also increases
                    3. RULE: Asset & Expense have normal Debit Balance, Liability & Equity & Revenue have normal Credit Balance
                */
                //Get company Other Expense Account
                //$account_payables = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_PAYABLE_CODE)->get()->first();
                $other_expense = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_OTHER_EXPENSE)->get()->first();
                //Get company Accounts Payables
                $debited_ac = $other_expense->code;
                $credited_ac = $custom_chart_of_coa->code;
                $amount = $request->opening_balance;
                $as_at = $this->helper->format_lunox_date($request->as_of);
                $trans_type = AccountsCoa::TRANS_TYPE_SUPPLIER_OPENING_BALANCE;
                $reference_number = AccountsCoa::TRANS_TYPE_OPENING_BALANCE;
                $trans_name = $request->legal_name.' '.$reference_number;
                //$ac_number = $vendor_account->account_number;
                //$account_number = $vendor_account->account_number;
                
                //
                $ledger_support_document = $new_vendor->double_entry_support_document()->create(['trans_type'=>$trans_type]);
                $transaction_id = $this->helper->getToken(10,'SOBP');
                $double_entry = $this->accountingVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_type,$transaction_id);
                $double_entry->supports()->save($ledger_support_document);
                //$support_doc = $new_vendor->double_entry_support_document()->create(['trans_type'=>$trans_type,'trans_name'=>$trans_name,'reference_number'=>$reference_number,'account_number'=>$account_number,'voucher_id'=>$double_entry->id]);
                // $support_doc = $double_entry->support_documents()->create(['trans_type'=>$trans_type,'trans_name'=>$trans_name,'account_number'=>$ac_number,'reference_number'=>$reference_number]);
                // $support_doc = $new_vendor->double_entry_support_document()->save($support_doc);
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

    public function update(Request $request,$uuid){

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
            'currency_id'=>'required',
            'payment_term_id'=>'required',
            'display_as'=>'required',
            'credit_limit'=>'required',
            'default_discount'=>'required'
        ];

        if($request->has('inactive_active_action')){
            DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->beginTransaction();
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
            $supplier = $this->suppliers->findByUuid($uuid);
            $supplier_ledger_ac = $supplier->ledger_accounts()->get()->first();
            $ledger_ac_balance = $this->accountingVouchers->calculate_account_balance($supplier_ledger_ac);
            if( ($ledger_ac_balance) && (!$request->status) ){
                DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ["Account balance must be zero before flagging an account as in-active"];
                return response()->json($http_resp,422);
            }else{
                $supplier->status = $request->status;
                $supplier->save();
                DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->commit();
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
                return response()->json($http_resp);
            }
        }

        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        Log::info($request);
        // Log::info($uuid);
        // DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->commit();
        // DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{
            //
            $company = $this->practices->find($request->user()->company_id);
            $supplier = $this->suppliers->findByUuid($uuid);
            $supplier_ledger_ac = $supplier->ledger_accounts()->get()->first();
            $ledger_ac_balance = $this->accountingVouchers->calculate_account_balance($supplier_ledger_ac);
            if( ($ledger_ac_balance) && (!$request->status) ){
                DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ["Account balance must be zero before flagging an account as in-active"];
                return response()->json($http_resp,422);
            }
            //Check if email is already taken
            $inputs = $request->all();
            if( $company->vendors()->where('email',$request->email)->where('id','!=',$supplier->id)->get()->first() ){
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
            if( $company->vendors()->where('mobile',$encoded_mobile)->where('id','!=',$supplier->id)->get()->first() ){
                DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ["Mobile already in use"];
                return response()->json($http_resp,422);
            }

            if( $company->vendors()->where('tax_reg_number',$request->tax_reg_number)->where('id','!=',$supplier->id)->get()->first() ){
                DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ["Tax registration number already in use!"];
                return response()->json($http_resp,422);
            }

            if( $company->vendors()->where('legal_name',$request->legal_name)->where('id','!=',$supplier->id)->get()->first() ){
                DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ["Contact/Legal name already in use!"];
                return response()->json($http_resp,422);
            }

            //----------------------------------------------------------------------------------------------------
            //Attach to currency
            $currecy = $this->countries->findByUuid($request->currency_id);
            $inputs['currency_id'] = $currecy->id;
            //Attach Payment Terms
            $payment_term = $this->paymentTerms->findByUuid($request->payment_term_id);
            $inputs['payment_term_id'] = $payment_term->id;
            //Attach to VAT
            if($request->vat_id){
                $tax = $this->taxations->findByUuid($request->vat_id);
                $inputs['default_vat_id'] = $tax->id;
            }
            //Update vendor
            $supplier->update($inputs);

            //Attach this Vendor to Account
            $ac_inputs = $request->all();
            $ac_inputs['name'] = $supplier->first_name;
            //**$vendor_account = $supplier->account_holders()->update($ac_inputs);

            //Attach addresses to this account
            //Log::info($request);
            $bil_add = $request->billing;
            $ship_add = $request->shipping;
            //$billing_ad = $this->supplierAddresses->findByUuid($bil_add['id']);
            $billing_ad = $supplier->addresses()->where('type',Product::BILLING_ADDRESS)->get()->first();
            if($billing_ad){
                $billing_ad->update($bil_add);
            }
            $shipping_ad = $supplier->addresses()->where('type',Product::SHIPPING_ADDRESS)->get()->first();
            if($shipping_ad){
                $shipping_ad->update($ship_add);
            }

            //Save Supplier Bank Account
            if($request->bank_id){
                $bank = $this->banks->findByUuid($request->bank_id);
                $inputs['bank_id'] = $bank->id;
            }
            if($request->bank_branch_id){
                $bank_branch = $this->bankBranches->findByUuid($request->bank_branch_id);
                $inputs['branch_id'] = $bank_branch->id;
            }
            if($request->account_type_id){
                $account_type = $this->accountTypes->findByUuid($request->account_type_id);
                $inputs['account_type_id'] = $account_type->id;
            }
            $inputs['balance'] = 0;
            $supplier_bank_account = $this->bankAccounts->findByUuid($request->bank_account['id']);
            $supplier_bank_account->update($inputs);
            // $supplier_bank_account = $supplier->bank_accounts()->update($inputs); //bank_account
            
            $supplier_ledger_ac->name = $request->legal_name;
            $supplier_ledger_ac->save();
            //----------------------------------------------------------------------------------------------------

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

    public function show($uuid){
        $http_resp = $this->http_response['200'];
        $supplier = $this->suppliers->findByUuid($uuid);
        $http_resp['results'] = $this->suppliers->transform_supplier($supplier);
        return response()->json($http_resp);
    }

    public function destroy($uuid){
        $http_resp = $this->http_response['200'];
        $supplier = $this->suppliers->findByUuid($uuid);
        $supplier->delete();
        $http_resp['results'] = $this->suppliers->transform_supplier($supplier);
        return response()->json($http_resp);
    }

    public function reports(Request $request){

        $http_resp = $this->http_response['200'];
        $results = array();
        $company = $this->practices->find($request->user()->company_id);
        $custom_filters = json_decode($request->filters,true);
        Log::info($company);
        switch ($custom_filters['report_name']) {
            case 'List of Suppliers':
                $vendors = $company->vendors()->orderByDesc('created_at')->paginate(100);
                $paged_data = $this->helper->paginator($vendors,$company);
                foreach( $vendors as $vendor){
                    array_push($results, $this->suppliers->transform_supplier($vendor));
                }
                $paged_data['data'] = $results;
                $http_resp['results'] = $paged_data;
                break;
            
            default:
                # code...
                break;
        }
        return response()->json($http_resp);
    }

}

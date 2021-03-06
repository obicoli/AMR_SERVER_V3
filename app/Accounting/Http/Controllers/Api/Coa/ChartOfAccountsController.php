<?php

namespace App\Accounting\Http\Controllers\Api\Coa;

// use App\Accounting\Models\Banks\AccountBankAccountType;
// use App\Accounting\Models\Banks\AccountMasterBank;
use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\COA\AccountsNature;
use App\Accounting\Models\COA\AccountsType;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Accounting\Repositories\AccountingRepository;
use App\Customer\Models\Customer;
use App\Customer\Repositories\CustomerRepository;
use App\Finance\Models\Banks\AccountBankAccountType;
use App\Finance\Models\Banks\AccountMasterBank;
use App\helpers\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
//use App\Models\Product\ProductTaxation;
use App\Models\Practice\Taxation\PracticeTaxation;
use App\Repositories\Practice\PracticeRepository;
use App\Supplier\Models\Supplier;
use App\Supplier\Repositories\SupplierRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ChartOfAccountsController extends Controller
{
    protected $accountChartAccount;
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $accountTypes;
    protected $accountsCoa;
    protected $accountingVouchers;
    protected $customers;
    protected $suppliers;
    protected $accountNatures;
    protected $practiceTaxation;

    public function __construct(AccountChartAccount $accountChartAccount)
    {
        $this->http_response = Config::get('response.http');
        $this->accountChartAccount = new AccountingRepository($accountChartAccount);
        $this->practices = new PracticeRepository( new Practice() );
        $this->helper = new HelperFunctions();
        $this->accountTypes = new AccountingRepository( new AccountsType() );
        $this->accountsCoa = new AccountingRepository( new AccountsCoa() );
        $this->accountingVouchers = new AccountingRepository( new AccountsVoucher() );
        $this->customers = new CustomerRepository(new Customer() );
        $this->suppliers = new SupplierRepository( new Supplier() );
        $this->accountNatures = new AccountingRepository( new AccountsNature() );
        $this->practiceTaxation = new PracticeRepository( new PracticeTaxation() );
    }

    public function delete($uuid){
        $http_resp = $this->http_response['200'];
        $coa = $this->accountChartAccount->findByUuid($uuid);
        $trans_data = $this->accountChartAccount->transform_company_chart_of_account($coa);
        if($trans_data['balance']>0 || $trans_data['total_transaction']>0 || ($trans_data['is_special']==true) ){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ["This account cannot be deleted!"];
            return response()->json($http_resp,422);
        }
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{
            $coa->forceDelete();
            $http_resp['description'] = "Account successful deleted!";
        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $results = array();
        $company = $this->practices->find($request->user()->company_id);
        //Get Chart of Accounts under this company
        if($request->has('default_code')){
            $company_chart_of_accounts = $company->chart_of_accounts()
            ->where('default_code',$request->default_code)
            ->where('is_sub_account',0)
            ->orderByDesc('accounts_type_id')
            ->paginate(200);
        }elseif( $request->has('account_nature') ){
            $account_nature = $this->accountNatures->findByName($request->account_nature);
            $account_types = AccountsType::where('accounts_nature_id',$account_nature->id)->pluck('id')->toArray();
            $company_chart_of_accounts = $company->chart_of_accounts()
                ->where('is_sub_account',0)
                ->whereIn('accounts_type_id',$account_types)
                ->paginate(150);
        }elseif($request->has('type_id')){
            $account_type = $this->accountTypes->findByUuid($request->type_id);
            $company_chart_of_accounts = $company->chart_of_accounts()
                ->where('is_special',true)
                ->where('is_sub_account',false)
                ->where('accounts_type_id',$account_type->id)
                ->orderByDesc('accounts_type_id')
                ->paginate(150);
        }elseif($request->has('search_key')){
            $company_chart_of_accounts = $company->chart_of_accounts()
            ->where('name', 'like', '%' .$request->search_key. '%')
            ->orderByDesc('accounts_type_id')
            ->paginate(15);
        }elseif($request->has('balance_sheet_accounts')){
            $open_balance_equity_code = AccountsCoa::AC_OPENING_BALANCE_EQUITY_CODE;
            $ac_payable_code = AccountsCoa::AC_PAYABLE;
            $ac_receivable_code = AccountsCoa::AC_RECEIVABLE_CODE;
            $company_chart_of_accounts = $company->chart_of_accounts()
                ->where('is_special',true)
                ->where('is_sub_account',false)
                ->where('default_code','!=',$open_balance_equity_code)
                ->where('code','!=',$open_balance_equity_code)
                ->where('default_code','!=',$ac_payable_code)
                ->where('default_code','!=',$ac_receivable_code)
                ->where('code','!=',$ac_receivable_code)
                ->where('code','!=',$ac_payable_code)
                ->orderBy('accounts_type_id')
                ->paginate(150);
        }elseif($request->has('account_type')){
            switch($request->account_type){
                case "Sales And Purchase":
                    $cos_code = AccountsCoa::AC_SALES_CODE;
                    $purchase_code = AccountsCoa::AC_INVENTORY_CODE;
                    $company_chart_of_accounts = $company->chart_of_accounts()
                        ->where('default_code',$cos_code)
                        ->orWhere('default_code',$purchase_code)
                        ->orderBy('accounts_type_id')
                        ->paginate(15);
                    break;
                case "Sales and Purchase Accounts":
                    $cos_code = AccountsCoa::AC_COST_OF_SALES_CODE;
                    $purchase_code = AccountsCoa::AC_INVENTORY_CODE;
                    $company_chart_of_accounts = $company->chart_of_accounts()
                    ->where('is_special',false)
                    ->where('is_sub_account',true)
                    ->where('default_code',$cos_code)
                    ->orWhere('default_code',$purchase_code)
                    ->orderBy('accounts_type_id')
                    ->paginate(15);
                    break;
                default:
                    $company_chart_of_accounts = $company->chart_of_accounts()->orderByDesc('accounts_type_id')->paginate(15);
                    break;
            }
        }elseif($request->has('grouped')){

            $company_chart_of_accounts = $company->chart_of_accounts()->get()->groupBy('accounts_type_id');
            $results = array();
            $default_filter = $this->helper->get_default_filter();
            foreach ($company_chart_of_accounts as $index => $company_chart_of_account){
                $account_type = $this->accountTypes->find($index);
                $accounts = array();
                $account_type_data = $this->accountTypes->transform_account_type($account_type);
                foreach ($company_chart_of_account as $company_chart){
                    array_push($accounts, $this->accountsCoa->transform_company_chart_of_account($company_chart));
                }
                $account_type_data['accounts'] = $accounts;
                array_push($results, $account_type_data);
            }
            $http_resp['results'] = $results;
            $http_resp['as_of'] = $default_filter['today'];
            return response()->json($http_resp);
        }
        else{
            $company_chart_of_accounts = $company->chart_of_accounts()
                ->orderBy('accounts_type_id')
                ->paginate(15);
        }
        $paged_data = $this->helper->paginator($company_chart_of_accounts);
        foreach ($company_chart_of_accounts as $company_chart_of_account) {
            array_push($paged_data['data'],$this->accountChartAccount->transform_company_chart_of_account($company_chart_of_account));
        }
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function create(Request $request){
        //Log::info($request);
        $http_resp = $this->http_response['200'];
        $http_resp_500 = $this->http_response['500'];
        $http_resp_422 = $this->http_response['422'];
        //Find the commpany
        $company = $this->practices->find($request->user()->company_id);

        if($request->has('sales_purchase')){ //Here Create a Sales or Purchase Account(Though it still chart of account)
            $rule = [
                'name'=>'required',
                'group_type'=>'required',
            ];
            $validation = Validator::make($request->all(),$rule,$this->helper->messages());
            if ($validation->fails()){
                $http_resp_422['errors'] = $this->helper->getValidationErrors($validation->errors());
                return response()->json($http_resp_422,422);
            }
            //Check if account name is in use
            $account_name = $company->chart_of_accounts()->where('name',$request->name)->where('default_code',$request->group_type)->get()->first();
            if($account_name){
                $http_resp_422['errors'] = ["Account name already in use"];
                return response()->json($http_resp_422,422);
            }
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
            try{
                //
                $inputs = $request->except(['group_type']);
                $mainAccount = $company->chart_of_accounts()->where('is_special',true)->where('is_sub_account',false)->where('default_code',$request->group_type)->get()->first();
                $account = $this->accountChartAccount->create_sub_chart_of_account($company,$mainAccount,$inputs,null);
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
                $http_resp['description'] = "Account successful created!";
                return response()->json($http_resp);
            }catch(\Exception $e){
                Log::info($e);
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                return response()->json($http_resp_500,500);
            }
        }else{
            $rule = [
                'name'=>'required',
                'account_type_id'=>'required',
                'detail_type_id'=>'required',
                //'as_of'=>'required',
                'is_sub_account'=>'required'
            ];
        }
        
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        if($request->is_sub_account){
            $rulea = [
                'main_account_id'=>'required',
            ];
            $validation = Validator::make($request->all(),$rulea,$this->helper->messages());
            if ($validation->fails()){
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                return response()->json($http_resp,422);
            }
        }
        
        //Here create chart of accounts
        //Log::info($request);
        //DB::beginTransaction();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{
            //Get selected account type
            $account_type = $this->accountTypes->findByUuid($request->account_type_id);
            $account_nature = $account_type->accounts_natures()->get()->first();
            //Allow Duplicate Names only if Type is different i.e Check if account name and type exists
            $company_coa = $company->chart_of_accounts()
                ->where('name',$request->name)
                ->where('accounts_type_id',$account_type->id)
                ->get()
                ->first();
            if(!$company_coa){
                //Create Chart of Account in default table() if is Not a sub_account
                $default_inputs = $request->all();
                $default_inputs['accounts_type_id'] = $account_type->id;
                $default_inputs['code'] = $this->helper->getAccountNumber();
                $default_inputs['name'] = $request->name;
                $default_vat = $this->productTaxation->findByUuid($request->vat_type_id);
                if($default_vat){
                    $default_inputs['vat_type_id'] = $default_vat->id;
                }
                
                if($request->is_sub_account){
                    // $rulea = [
                    //     'main_account_id'=>'required',
                    // ];
                    // $validation = Validator::make($request->all(),$rulea,$this->helper->messages());
                    // if ($validation->fails()){
                    //     $http_resp = $this->http_response['422'];
                    //     $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                    //     return response()->json($http_resp,422);
                    // }
                    //Get Company chart of account
                    $main_parent = $this->accountChartAccount->findByUuid($request->main_account_id);
                    //Then Get Default COA
                    $default_coa = $this->accountsCoa->findByUuid($request->detail_type_id);
                    Log::info($default_coa);
                    //$default_coa = $main_parent->coas()->get()->first();
                    $default_inputs['default_coa_id'] = $default_coa->id;
                    //$default_inputs['code'] = $this->helper->getAccountNumber();
                    $default_inputs['is_sub_account'] = true;
                    $default_inputs['default_code'] = $main_parent->default_code;
                    $custom_chart_of_coa = $this->accountChartAccount->create($default_inputs);
                    $custom_chart_of_coa = $company->chart_of_accounts()->save($custom_chart_of_coa);
                    //Log::info($request);
                }else{
                    // $default_coa = $this->accountsCoa->create($default_inputs);
                    $default_coa = $this->accountsCoa->findByUuid($request->detail_type_id);
                    //Log::info($default_coa);
                    //$default_coa = $coa->coas()->get()->first();
                    $default_inputs['default_coa_id'] = $default_coa->id;
                    $default_inputs['default_code'] = $default_coa->code;
                    $custom_chart_of_coa = $this->accountChartAccount->create($default_inputs);
                    $custom_chart_of_coa = $company->chart_of_accounts()->save($custom_chart_of_coa);
                }
                //Create Chart of Accounts in Custom Table i.e Companies COA
                // Log::info($custom_chart_of_coa);
                // Log::info($custom_chart_of_coa->coas()->get()->first());
                
                //Link account to company created it
                //Check if Balance is > 0 and Credit/Debit i.e Save Opening Balance Transaction
                if($request->balance){

                    $rulea = [
                        'as_of'=>'required',
                    ];
                    $validation = Validator::make($request->all(),$rulea,$this->helper->messages());
                    if ($validation->fails()){
                        $http_resp = $this->http_response['422'];
                        $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                        return response()->json($http_resp,422);
                    }

                    $as_of = $this->helper->format_lunox_date($request->as_of);

                    //Opening Balance Equity i.e "Capital" Credited
                    //The Newly Created "account" Debited
                    //Transaction Type is "Deposit"
                    //Transaction Description is "Opening Balance"
                    //The account created here if Opening Balance is > 0, the it should be a none inventory
                    //Check if is an Inventory Account
                    // $inv_acc = $this->accountsCoa->findByUuid($request->detail_type_id);
                    // if( AccountsCoa::AC_INVENTORY_CODE==$inv_acc->code ){
                    //     DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                    //     $http_resp = $this->http_response['422'];
                    //     $http_resp['errors'] = ['Choose a non inventory account for your deposit!'];
                    //     return response()->json($http_resp,422);
                    // }

                    //Check if Account Type is Receivable or Payable
                    if($account_type->name==AccountsCoa::AC_RECEIVABLE || $account_type->name==AccountsCoa::AC_PAYABLE){
                        $http_resp['errors'] = ["Choose a non '".$account_type->name."' account for your deposit!"];
                        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                        $http_resp = $this->http_response['422'];
                        return response()->json($http_resp,422);
                    }

                    /*
                        RULES ON OPENING/CREATING COA:
                        1. Income/Revenue, Expense Accounts when opening they dont have "Opening Balance" or "Unpaid Balance" field
                        2. Assets, Equity Accounts when opening they have Opening "Opening Balance" field
                        3. Liability Accounts when opening they have "Unpaid Balance" field
                        4. If "Opening Balance" or "Unpaid Balance" is provided during account opening, double entry transaction will be performed
                            between "newly" created account and "Opening Balance Equity(Capital)"
                        5. If newly created account is:-
                            (a) Assets : [Dr | Cr]==["New Ac" - "Opening Balance Equity"] Transaction is called "Opening Balance"
                            (b) Equity : [Dr | Cr]==["Opening Balance Equity" | "New Ac"] Transaction is called "Journal Entry"
                            (c) Liability : [Dr | Cr]==["Opening Balance Equity" | "New Ac"] Transaction is called "Journal Entry"
                        6. Inventory Account cannot have "Opening Balance" or "Unpaid Balance"
                        7. Once an account has been created with "Opening Balance" Opening Balance field should be hidden
                        8. Account Payable, Account Receivable dont have "OB" field on creation
                    */
                    //Generate a transaction ID
                    $transaction_id = $this->helper->getToken(10);
                    //Get Opening Balance Equity: To be Credited
                    //$op_bal_equity = $this->accountsCoa->findByCode(AccountsCoa::AC_OPENING_BALANCE_EQUITY);
                    //$custom_op_bal_equity = $op_bal_equity->chart_of_accounts()->where('is_sub_account',0)->get()->first();
                    //----$custom_op_bal_equity = $company->coas()->where('name',AccountsCoa::AC_OPENING_BALANCE_EQUITY)->get()->first();
                    $amount = $request->balance;
                    $trans_type = AccountsCoa::TRANS_NAME_OPEN_BALANCE;
                    $trans_name = "Account ".$trans_type;
                    $custom_op_bal_equity = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_OPENING_BALANCE_EQUITY_CODE)->get()->first();
                    if($account_nature->name == AccountsCoa::ASSETS){
                        //Assets : [Dr | Cr]==["New Ac" - "Opening Balance Equity"] Transaction is called "Opening Balance"
                        //Perform Double Entry
                        $debited_ac = $custom_chart_of_coa->code;
                        $credited_ac = $custom_op_bal_equity->code;
                        $double_entry = $this->accountingVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_of,$trans_name,$transaction_id);
                    }elseif($account_nature->name==AccountsCoa::EQUITY || $account_nature->name==AccountsCoa::LIABILITY){
                        $debited_ac = $custom_op_bal_equity->code;
                        $credited_ac = $custom_chart_of_coa->code;
                        $double_entry = $this->accountingVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_of,$trans_name,$transaction_id);
                    }
                    $ledger_support_document = $custom_chart_of_coa->double_entry_support_document()->create(['trans_type'=>$trans_type]);
                    $tax_support = $double_entry->supports()->save($ledger_support_document);
                }
                $http_resp['description'] = "Account successful created!";
            }else{
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ['Account name already in use!'];
                return response()->json($http_resp,422);
            }

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function update(Request $request, $uuid){

        $http_resp = $this->http_response['200'];
        Log::info($request);
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{

            $account_type = $this->accountTypes->findByUuid($request->account_type_id);
            $account_nature = $account_type->accounts_natures()->get()->first();
            //
            $company = $this->practices->find($request->user()->company_id);
            if( $request->has('status') ){ //Request to change status: Inactive or Active
                $company_chart_of_account = $this->accountChartAccount->findByUuid($uuid);
                $company_chart_of_account->status = $request->status;
                $company_chart_of_account->save();
                //Log::info($company_chart_of_account);
            }else{
                $rule = [
                    'name'=>'required',
                    'account_type_id'=>'required',
                    'detail_type_id'=>'required',
                    'is_sub_account'=>'required'
                ];
                $validation = Validator::make($request->all(),$rule,$this->helper->messages());
                if ($validation->fails()){
                    $http_resp = $this->http_response['422'];
                    $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                    return response()->json($http_resp,422);
                }
                //
                $company_chart_account = $this->accountChartAccount->findByUuid($uuid);
                $default_coa = $this->accountsCoa->findByUuid($request->default_coa_id);
                $inputs = $request->all();
                $vat = $this->productTaxation->findByUuid($request->vat_type_id);
                if($vat){
                    $inputs['vat_type_id'] = $vat->id;
                }
                $inputs['default_coa_id'] = $default_coa->id;
                $company_chart_account->update($inputs);
                $trans_data = $this->accountChartAccount->transform_company_chart_of_account($company_chart_account);
                if( ($request->balance>0) && ($trans_data['total_transaction']==0) && ($trans_data['balance']==0) ){
                    //Opening Balance Equity i.e "Capital" Credited
                    //The Newly Created "account" Debited
                    //Transaction Type is "Deposit"
                    //Transaction Description is "Opening Balance"
                    //The account created here if Opening Balance is > 0, the it should be a none inventory
                    //Check if is an Inventory Account
                    // $inv_acc = $this->accountsCoa->findByUuid($request->detail_type_id);
                    // Log::info($inv_acc);
                    if( AccountsCoa::AC_INVENTORY_CODE==$company_chart_account->default_code ){
                        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                        $http_resp = $this->http_response['422'];
                        $http_resp['errors'] = ['Choose a non inventory account for your deposit!'];
                        return response()->json($http_resp,422);
                    }
                    //Check if Account Type is Receivable or Payable
                    if($account_type->name==AccountsCoa::AC_RECEIVABLE || $account_type->name==AccountsCoa::AC_PAYABLE){
                        $http_resp['errors'] = ["Choose a non '".$account_type->name."' account for your deposit!"];
                        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                        $http_resp = $this->http_response['422'];
                        return response()->json($http_resp,422);
                    }
                    //Generate a transaction ID
                    $transaction_id = $this->helper->getToken(10);
                    //Get Opening Balance Equity: To be Credited
                    //$op_bal_equity = $this->accountsCoa->findByCode(AccountsCoa::AC_OPENING_BALANCE_EQUITY);
                    //$custom_op_bal_equity = $op_bal_equity->chart_of_accounts()->where('is_sub_account',0)->get()->first();
                    //----$custom_op_bal_equity = $company->coas()->where('name',AccountsCoa::AC_OPENING_BALANCE_EQUITY)->get()->first();
                    $amount = $request->balance;
                    $trans_type = AccountsCoa::TRANS_NAME_OPEN_BALANCE;
                    $trans_name = "Account ".$trans_type;
                    $as_of = $this->helper->format_lunox_date($request->as_of);
                    $custom_op_bal_equity = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_OPENING_BALANCE_EQUITY_CODE)->get()->first();
                    if($account_nature->name == AccountsCoa::ASSETS){
                        //Assets : [Dr | Cr]==["New Ac" - "Opening Balance Equity"] Transaction is called "Opening Balance"
                        //Perform Double Entry
                        $debited_ac = $company_chart_account->code;
                        $credited_ac = $custom_op_bal_equity->code;
                        $double_entry = $this->accountingVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_of,$trans_type,$transaction_id);
                    }elseif($account_nature->name==AccountsCoa::EQUITY || $account_nature->name==AccountsCoa::LIABILITY){
                        $debited_ac = $custom_op_bal_equity->code;
                        $credited_ac = $company_chart_account->code;
                        $double_entry = $this->accountingVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_of,$trans_type,$transaction_id);
                        //$double_entry = $this->accountingVouchers->accounts_double_entry($company,$custom_op_bal_equity->code,$company_chart_account->code,$request->balance,$request->as_of,AccountsCoa::TRANS_NAME_JOURNAL_ENTRY,$transaction_id);
                    }
                    //Link it to company user performing the transaction
                    //Create a supporting Document for this transaction
                    $support_doc = $double_entry->support_documents()->create(['trans_type'=>AccountsCoa::TRANS_TYPE_DEPOSIT,'trans_name'=>AccountsCoa::TRANS_NAME_OPEN_BALANCE]);
                    $ledger_support_document = $company_chart_account->double_entry_support_document()->create(['trans_type'=>$trans_type]);
                    $tax_support = $double_entry->supports()->save($ledger_support_document);
                    // //Generate a transaction ID
                    // $transaction_id = $this->helper->getToken(10);
                    // //Get Opening Balance Equity: To be Credited
                    // $op_bal_equity = $this->accountsCoa->findByCode(AccountsCoa::AC_OPENING_BALANCE_EQUITY_CODE);
                    // $custom_op_bal_equity = $op_bal_equity->chart_of_accounts()->where('is_sub_account',0)->get()->first();
                    // //Perform Double Entry
                    // $double_entry = $this->accountingVouchers->accounts_double_entry($company,$custom_op_bal_equity->code,$company_chart_account->code,$request->balance,$request->as_of,"Opening Balance",$transaction_id);
                    // //Link it to company user performing the transaction
                    // //Create a supporting Document for this transaction
                    // $support_doc = $double_entry->support_documents()->create(['trans_type'=>AccountsCoa::TRANS_TYPE_DEPOSIT,'trans_name'=>AccountsCoa::TRANS_NAME_OPEN_BALANCE]);
                }
            }
            $http_resp['description'] = "Account successful updated!";
        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function show(Request $request, $uuid){
        $http_resp = $this->http_response['200'];
        $coa = $this->accountChartAccount->findByUuid($uuid);
        //$default_filter = $this->helper->get_default_filter();
        //$filters['date_range'] = $default_filter['start'].' to '.$default_filter['end'];
        //$results['filters'] = $filters;
        $results['data'] = $this->accountChartAccount->transform_company_chart_of_account($coa);
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }

    public function initials(Request $request){

        $http_resp = $this->http_response['200'];
        $company = $this->practices->find($request->user()->company_id);
        //Log::info($request->user()->company_id);
        $results = array();
        //Get Account Types
        $acc_types = array();
        $account_types = $this->accountTypes->all();
        foreach ($account_types as $account_type) {
            array_push($acc_types,$this->accountTypes->transform_account_type($account_type));
        }

        //Get Default Chart of Accounts
        //$default_chart_of_accounts = $this->accountsCoa->getDefaultCoa();
        // $default_chart_of_accounts = $company->coas()->where('sys_default',true)->get();
        // $default_acc = array();
        // foreach ($default_chart_of_accounts as $default_chart_of_account) {
        //     array_push($default_acc, $this->accountsCoa->transform_default_coa($default_chart_of_account));
        // }
        $default_chart_of_accounts = AccountsCoa::all()
            ->where('sys_default',true)
            ->where('owning_id','')
            ->where('owning_type','');
        $default_acc = array();
        foreach ($default_chart_of_accounts as $default_chart_of_account) {
            array_push($default_acc, $this->accountsCoa->transform_default_coa($default_chart_of_account));
        }

        $payment_methods = array();
        $payment_types = $company->accounts_payment_methods()->get();
        foreach ($payment_types as $payment_type) {
            array_push($payment_methods,$this->accountChartAccount->transform_payment_type($payment_type));
        }

        $customer_terms = array();
        $termss = $company->customer_terms()->get();
        foreach( $termss as $terms){
            array_push($customer_terms,$this->customers->transform_term($terms));
        }

        $supplier_terms = array();
        $supp_termss = $company->supplier_terms()->get();
        foreach( $supp_termss as $supp_terms){
            array_push($supplier_terms,$this->suppliers->transform_term($supp_terms));
        }

        $customers = array();
        $company_customers = $company->customers()->orderBy('created_at', 'desc')->get();
        Log::info($company_customers);
        foreach($company_customers as $company_customer){
            array_push($customers,$this->customers->transform_customer($company_customer));
        }

        //Company Chart of Accounts
        $company_coas = array();
        $company_chart_of_accounts = $company->chart_of_accounts()->get()->sortBy('accounts_type_id');
        foreach ($company_chart_of_accounts as $company_chart_of_account) {
            array_push($company_coas,$this->accountChartAccount->transform_company_chart_of_account($company_chart_of_account));
        }

        $banking = array();
        $bank_account_type = array();
        $banks = array();

        $account_typesy = AccountBankAccountType::all()->sortBy('name');
        foreach($account_typesy as $account_ty){
            $tempa['id'] = $account_ty->uuid;
            $tempa['name'] = $account_ty->name;
            array_push($bank_account_type,$tempa);
        }

        $bankers = AccountMasterBank::all()->sortBy('name');
        foreach($bankers as $banker){
            $branches = array();
            $temp_bank['id'] = $banker->uuid;
            $temp_bank['name'] = $banker->name;
            $bankers_branches = $banker->branches()->get();
            foreach($bankers_branches as $bankers_branche){
                $temp_branch['id'] = $bankers_branche->uuid;
                $temp_branch['name'] = $bankers_branche->name;
                $temp_branch['code'] = $bankers_branche->code;
                array_push($branches,$temp_branch);
            }
            $temp_bank['branches'] = $branches;
            array_push($banks,$temp_bank);
        }

        $banking['account_types'] = $bank_account_type;
        $banking['banks'] = $banks;


        //Get tax code
        $tax_codes = array();
        $results['account_types'] = $acc_types;
        $results['accounts'] = $default_acc;
        $results['company_coas'] = $company_coas;
        $results['tax_codes'] = $tax_codes;
        $results['payment_methods'] = $payment_methods;
        $results['customer_terms'] = $customer_terms;
        $results['supplier_terms'] = $supplier_terms;
        $results['customers'] = $customers;
        $results['banking'] = $banking;
        //$results['banks'] = [];
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }

}

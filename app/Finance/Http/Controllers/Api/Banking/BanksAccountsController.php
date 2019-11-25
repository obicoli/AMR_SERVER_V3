<?php

namespace App\Finance\Http\Controllers\Api\Banking;

use App\Finance\Models\Banks\AccountMasterBank;
use App\Finance\Models\Banks\AccountMasterBankBranch;
use App\Finance\Models\Banks\AccountsBank;
use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\COA\AccountsType;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Accounting\Repositories\AccountingRepository;
use App\Customer\Models\Customer;
use App\Customer\Repositories\CustomerRepository;
use App\Finance\Models\Banks\AccountBankAccountType;
use App\Finance\Models\Banks\BankReconciliation;
use App\Finance\Models\Banks\BankTransaction;
use App\Finance\Models\Banks\ReconciledTransactionState;
use App\Finance\Repositories\FinanceRepository;
use App\helpers\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeUser;
use App\Repositories\Practice\PracticeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BanksAccountsController extends Controller
{
    protected $accountsBank;
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $banks;
    protected $bank_branches;
    protected $bank_account_types;
    // protected $accountTypes;
    protected $accountsCoa;
    protected $accountingVouchers;
    protected $accountChartAccount;
    protected $bankTransaction;
    protected $bankReconciliations;
    protected $bankReconciledTransactionState;
    protected $companyUser;
    // protected $customers;

    public function __construct(AccountsBank $accountsBank)
    {
        $this->http_response = Config::get('response.http');
        $this->accountsBank = new FinanceRepository($accountsBank);
        $this->practices = new PracticeRepository( new Practice() );
        $this->helper = new HelperFunctions();
        $this->banks = new FinanceRepository( new AccountMasterBank() );
        $this->bank_branches = new FinanceRepository( new AccountMasterBankBranch() );
        $this->bank_account_types = new FinanceRepository( new AccountBankAccountType() );
        // $this->accountTypes = new AccountingRepository( new AccountsType() );
        $this->accountsCoa = new AccountingRepository( new AccountsCoa() );
        $this->accountingVouchers = new AccountingRepository( new AccountsVoucher() );
        // $this->customers = new CustomerRepository(new Customer());
        $this->accountChartAccount = new AccountingRepository( new AccountChartAccount());
        $this->bankTransaction = new FinanceRepository(new BankTransaction());
        $this->bankReconciliations = new FinanceRepository( new BankReconciliation() );
        $this->bankReconciledTransactionState = new FinanceRepository( new ReconciledTransactionState() );
        $this->companyUser = new PracticeRepository( new PracticeUser());
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $results = array();
        $company = $this->practices->find($request->user()->company_id);
        $accounts = $company->bank_accounts()->get();
        foreach( $accounts as $account ){
            array_push($results,$this->accountsBank->transform_bank_accounts($account));
        }
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }

    public function create(Request $request){

        //Log::info($request);
        $http_resp = $this->http_response['200'];
        $rule = [
            'account_name'=>'required',
            'account_number'=>'required',
            'bank_id'=>'required',
            'branch_id'=>'required',
            'is_default'=>'required',
            'status'=>'required',
            'account_type_id'=>'required'
        ];
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->beginTransaction();
        try{

            $company = $this->practices->find($request->user()->company_id);
            $companyUser = $this->companyUser->findByUserAndCompany($request->user(),$company);
            $bank = $this->banks->findByUuid($request->bank_id);
            $bank_branch = $this->bank_branches->findByUuid($request->branch_id);
            $bank_account_type = $this->bank_account_types->findByUuid($request->account_type_id);
            //Check if selected branch belongs to seletced bank
            $bank_branch = $bank->branches()->find($bank_branch->id);
            if(!$bank_branch){
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ['Selected branch does not belong to bank institution!'];
                return response()->json($http_resp,422);
            }
            //Check if account number already already exists
            if( $company->bank_accounts()->where('account_number',$request->account_number)->where('bank_id',$bank->id)->get()->first() ){
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ['Account number already in use!'];
                return response()->json($http_resp,422);
            }
            //
            $inputs = $request->except(['bank','bank_branch','account_type']);
            $inputs['bank_id'] = $bank->id;
            $inputs['branch_id'] = $bank_branch->id;
            $inputs['account_type_id'] = $bank_account_type->id;
            /*
                1. Create new bank account
                2. Create Bank's Ledger account(Is a current assets Ledger Account) and Should be a sub account of "Bank
                3. If Opening Balance is provided
                    DEBIT "Bank's Ledger account" & CREDIT "Owner's Equity"
            */
            //(A). Create new bank account
            $new_bank_account = $company->bank_accounts()->create($inputs);
            if($request->is_default){
                //The newly created bank should be the operating bank i.e Default
                $current_default = $company->bank_accounts()->where('is_default',true)->get()->first();
                if($current_default){
                    $current_default->is_default = false;
                    $current_default->save();
                }
                $new_bank_account->is_default = true;
                $new_bank_account->save();
            }else{//Make it default if non default bank account
                $current_default = $company->bank_accounts()->where('is_default',true)->get()->first();
                if(!$current_default){
                    $new_bank_account->is_default = true;
                    $new_bank_account->save();
                }
            }

            if($request->is_sub_account){
                //Get the system COA called "Bank"
                $system_bank_coa = $this->accountsCoa->findByCode(AccountsCoa::AC_BANK_CODE);
                //Get Company Parent COA called "Bank"
                //$main_parent = $this->accountChartAccount->findByDefaultCode(AccountsCoa::AC_BANK_CODE); //Will be replaced by "User Specified Main Account"
                $main_parent = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_BANK_CODE)->get()->first();
                $default_coa = $main_parent->coas()->get()->first();
                $default_inputs['accounts_type_id'] = $main_parent->accounts_type_id;
                $default_inputs['code'] = $this->helper->getAccountNumber();
                $default_inputs['name'] = $request->account_name;
                $default_inputs['default_coa_id'] = $default_coa->id;
                //$default_inputs['code'] = $this->helper->getAccountNumber();
                $default_inputs['is_sub_account'] = true;
                $default_inputs['default_code'] = $main_parent->default_code;
                $custom_chart_of_coa = $this->accountChartAccount->create($default_inputs);
                $custom_chart_of_coa = $company->chart_of_accounts()->save($custom_chart_of_coa);
                $bank_ledger_ac = $custom_chart_of_coa->bank_accounts()->save($new_bank_account);
            }else{ //Create as the Main Account

                //(B). CREATING BANKS LEDGER ACCOUNT: 4 Steps
                //Step 1. Find Default Bank(Bank balances) account
                $default_bank_coa = $this->accountsCoa->findByCode(AccountsCoa::AC_BANK_CODE);
                //Step 2. Create Bank's Legder Account in AccountsCoa
                $inpos['name'] = $request->account_name;
                //$inpos['code'] = $default_bank_coa->code.'0000'.$facility->id;
                $inpos['code'] = $new_bank_account->id.'00'.$default_bank_coa->code.'00'.$company->id;
                $inpos['accounts_type_id'] = $default_bank_coa->accounts_type_id;
                $inpos['sys_default'] = true;
                $inpos['is_special'] = false;
                $default_account = $this->accountsCoa->create($inpos);
                //Link above account to company
                $default_account = $company->coas()->save($default_account);
                //Step 3. Create this company default&special account in debitable,creditable table
                $inputs2['name'] = $request->account_name;
                $inputs2['code'] = $new_bank_account->id.'00'.$default_bank_coa->code.'00'.$company->id;
                $inputs2['accounts_type_id'] = $default_bank_coa->accounts_type_id;
                $inputs2['default_code'] = $default_bank_coa->code;
                $inputs2['is_special'] = true;
                $custom_chart_of_coa = $default_account->chart_of_accounts()->create($inputs2);//This also links it to parent default account
                //Link above debitable_creditable_ac account to a company
                $custom_chart_of_coa = $company->chart_of_accounts()->save($custom_chart_of_coa);
                //Step 4. Link bank account to Ledger
                $bank_ledger_ac = $custom_chart_of_coa->bank_accounts()->save($new_bank_account);
            }

            //(C) OPENING BALANCES
            if($request->has('opening_balance') && $request->opening_balance>0){

                $new_bank_account->balance = $new_bank_account->balance + $request->opening_balance;
                $new_bank_account->save();
                //DEBIT "Bank's Ledger account" & CREDIT "Owner's Equity"
                $rule2 = [
                    'as_at'=>'required',
                ];
                $opening_balance = $request->opening_balance;
                $as_at = $request->as_at;

                $validation = Validator::make($request->all(),$rule2,$this->helper->messages());
                if ($validation->fails()){
                    $http_resp = $this->http_response['422'];
                    $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                    return response()->json($http_resp,422);
                }

                $transaction_id = $this->helper->getToken(10);
                $custom_op_bal_equity = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_OPENING_BALANCE_EQUITY_CODE)->get()->first();


                
                $debited_ac = $custom_chart_of_coa->code;
                $credited_ac = $custom_op_bal_equity->code;
                $amount = $opening_balance;
                $as_at = $request->as_at;
                $trans_type = AccountsCoa::TRANS_TYPE_ACCOUNT_OPENING_BALANCE;
                $reference_number = AccountsCoa::TRANS_TYPE_OPENING_BALANCE;
                $trans_name = $trans_type;
                $account_number = $new_bank_account->account_number;
                //$ac_number = $vendor_account->account_number;

                //Create a Bank Transaction(The Type is "Account" )
                //Link Bank Transaction to Bank Ledger Account(Transactionable:PolyMorphy)
                //Create a Reconciliation Transaction
                //Create the Three Status of this Transaction
                $bank_inputs['transaction_date'] = $as_at;
                $bank_inputs['type'] = AccountsCoa::AC_TYPE_ACCOUNT;
                $bank_inputs['reference'] = $reference_number;
                $bank_inputs['received'] = $amount;
                $bank_inputs['bank_account_id'] = $new_bank_account->id;
                $bank_inputs['status'] = AccountsCoa::RECONCILIATION_RECONCILED;
                //$transacted = $this->bankTransaction->create($bank_inputs);

                /*
                    The Statement Below Perfoms the following:
                    1. Creates a Bank Transaction
                    2. Links Bank Transaction to Ledger Account, since Transaction is of Type "Account"
                */
                $transacted = $custom_chart_of_coa->bank_transactions()->create($bank_inputs); //NOTE: "$transacted" is a bank_transaction

                /*
                    Reconciling Above Bank Transaction is Performed by Statements Below
                */
                $reco_inputs['account_balance'] = $amount;
                $reco_inputs['reconciled_amount'] = $amount;
                $reco_inputs['statement_balance'] = $amount;
                $reco_inputs['bank_account_id'] = $new_bank_account->id;
                $reco_inputs['start_date'] = $as_at;
                $reco_inputs['end_date'] = $as_at;
                $reco_inputs['notes'] = $reference_number;
                $reco_inputs['status'] = AccountsCoa::RECONCILIATION_RECONCILED;
                $bank_reconciliation = $this->bankReconciliations->create($reco_inputs);//Create a Reconciliation
                //Link Above Reconciliation to a Transaction as Below:
                $reco_inputs['bank_transaction_id'] = $transacted->id;
                $reconciled_transaction = $bank_reconciliation->reconciled_transactions()->create($reco_inputs);
                //Create the new next Bank Reconciliation
                $this->bankReconciliations->getOrCreateBankReconciliation($new_bank_account,$as_at);

                /*
                    Record The Final Status "Reconciled" for this Transaction: Below Statements Performs this.
                */
                $state_inputs['reconciled_transaction_id'] = $reconciled_transaction->id;
                $state_inputs['status'] = AccountsCoa::RECONCILIATION_RECONCILED;
                $state_inputs['notes'] = $companyUser->first_name." opened a bank account";
                //$status = $this->bankReconciledTransactionState->create($state_inputs);
                $status = $companyUser->reconciled_transaction_state()->create($state_inputs);

                $double_entry = $this->accountingVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);

                $support_doc = $custom_chart_of_coa->double_entry_support_document()->create(['trans_type'=>$trans_type,'trans_name'=>$trans_name,
                    'reference_number'=>$reference_number,'account_number'=>$account_number,'voucher_id'=>$double_entry->id]);
                // $support_doc = $double_entry->support_documents()->create(['trans_type'=>$trans_type,'trans_name'=>$trans_name,
                //     'reference_number'=>$reference_number,'account_number'=>$account_number]);
                //$support_doc = $new_bank_account->double_entry_support_document()->save($support_doc);

            }else{
                $this->bankReconciliations->getOrCreateBankReconciliation($new_bank_account,date("Y-m-d H:i:s"));
            }

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function update(Request $request,$uuid){
        //Log::info($request);
        $http_resp = $this->http_response['200'];
        $rule = [
            'account_name'=>'required',
            'account_number'=>'required',
            'bank_id'=>'required',
            'branch_id'=>'required',
            'is_default'=>'required',
            'status'=>'required',
            'account_type_id'=>'required'
        ];
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->beginTransaction();
        try{
            $company = $this->practices->find($request->user()->company_id);
            $bank = $this->banks->findByUuid($request->bank_id);
            $bank_branch = $this->bank_branches->findByUuid($request->branch_id);
            $bank_account_type = $this->bank_account_types->findByUuid($request->account_type_id);
            $bank_account = $this->accountsBank->findByUuid($uuid);
            //
            $inputs = $request->except(['bank','bank_branch','account_type','balance','opening_balance']);
            $inputs['bank_id'] = $bank->id;
            $inputs['branch_id'] = $bank_branch->id;
            $inputs['account_type_id'] = $bank_account_type->id;
            $bank_account->update($inputs);
            $http_resp['description'] = "Successful updated bank account!";
            if($request->is_default){
                //The newly created bank should be the operating bank i.e Default
                $current_default = $company->bank_accounts()->where('is_default',true)->get()->first();
                if($current_default){
                    $current_default->is_default = false;
                    $current_default->save();
                }
                $bank_account->is_default = true;
                $bank_account->save();
            }
            
        }catch(\Exception $e){

            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
            return response()->json($http_resp,500);

        }
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function show(Request $request, $uuid){

        $http_resp = $this->http_response['200'];
        $bank_account = $this->accountsBank->findByUuid($uuid);
        $transactions = null;
        $company = $this->practices->find($request->user()->company_id);
        if($request->has('filters')){
            $transactions = $bank_account->bank_transactions()
                ->where('reference','!=',AccountsCoa::TRANS_TYPE_OPENING_BALANCE)
                ->orderByDesc('created_at')
                ->paginate(15);
        }else{ //Get default filter which is the current month
            $default_filters = $this->helper->get_default_filter();
            $transactions = $bank_account->bank_transactions()
                ->where('reference','!=',AccountsCoa::TRANS_TYPE_OPENING_BALANCE)
                ->orderByDesc('created_at')
                ->paginate(15);
        }

        $paged_data = $this->helper->paginator($transactions);
        //Log::info($transactions);
        foreach ($transactions as $transaction) {
            array_push($paged_data['data'],$this->accountsBank->transform_bank_transaction($transaction,$company));
        }
        
        $transformed_account = $this->accountsBank->transform_bank_accounts($bank_account);
        $transformed_account['transaction'] = $paged_data;
        $http_resp['results'] = $transformed_account;
        return response()->json($http_resp);
        
    }

    public function destroy(Request $request, $uuid){
        $http_resp = $this->http_response['200'];
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->beginTransaction();
        try{

            $bank_account = $this->accountsBank->findByUuid($uuid);
            if($bank_account->is_default){
                $company = $this->practices->find($request->user()->company_id);
                $next_default = $company->bank_accounts()->where('id','!=',$bank_account->id)->get()->first();
                if($next_default){
                    $next_default->is_default = true;
                    $next_default->save();
                }
            }
            $this->accountsBank->delete($bank_account->id);
            $http_resp["description"] = "Bank account deleted successful!";

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->commit();
        return response()->json($http_resp);
    }

}

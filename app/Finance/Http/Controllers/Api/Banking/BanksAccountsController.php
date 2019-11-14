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
use App\Finance\Repositories\FinanceRepository;
use App\helpers\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
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
    // protected $accountingVouchers;
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
        // $this->accountingVouchers = new AccountingRepository( new AccountsVoucher() );
        // $this->customers = new CustomerRepository(new Customer());
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
                2. Create Bank's Ledger account(Is a current assets Ledger Account)
                3. If Opening Balance is provided
                    DEBIT "Bank's Ledger account" & CREDIT "Owner's Equity"
            */
            //(A). Create new bank account
            $new_bank_account = $company->bank_accounts()->create($inputs);

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
                    $debitable_creditable_ac = $default_account->chart_of_accounts()->create($inputs2);//This also links it to parent default account
                    //Link above debitable_creditable_ac account to a company
                    $debitable_creditable_ac = $company->chart_of_accounts()->save($debitable_creditable_ac);
                //Step 4. Link bank account to Ledger
                    $bank_ledger_ac = $default_account->bank_accounts()->save($new_bank_account);
            //(C) OPENING BALANCES

        }catch(\Exception $e){

            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
            return response()->json($http_resp,500);

        }

        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
        return response()->json($http_resp);

    }

}

<?php

namespace App\Accounting\Http\Controllers\Api\Coa;

// use App\Accounting\Models\Banks\AccountBankAccountType;
// use App\Accounting\Models\Banks\AccountMasterBank;
use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\COA\AccountsNature;
use App\Accounting\Models\COA\AccountsOpeningBalance;
use App\Accounting\Models\COA\AccountsType;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Accounting\Repositories\AccountingRepository;
use App\Customer\Models\Customer;
use App\Customer\Repositories\CustomerRepository;
use App\Finance\Models\Banks\AccountBankAccountType;
use App\Finance\Models\Banks\AccountMasterBank;
use App\helpers\HelperFunctions;
use App\Models\Practice\Taxation\PracticeTaxation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Repositories\Practice\PracticeRepository;
use App\Supplier\Models\Supplier;
use App\Supplier\Repositories\SupplierRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OpeningBalanceController extends Controller
{
    protected $accountsOpeningBalance;
    protected $chartOfAccounts;
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

    public function __construct(AccountsOpeningBalance $accountsOpeningBalance)
    {
        $this->http_response = Config::get('response.http');
        $this->accountsOpeningBalance = new AccountingRepository($accountsOpeningBalance);
        $this->chartOfAccounts = new AccountingRepository( new AccountChartAccount() );
        $this->practices = new PracticeRepository( new Practice() );
        $this->helper = new HelperFunctions();
        $this->accountTypes = new AccountingRepository( new AccountsType() );
        $this->accountsCoa = new AccountingRepository( new AccountsCoa() );
        $this->accountingVouchers = new AccountingRepository( new AccountsVoucher() );
        $this->customers = new CustomerRepository(new Customer());
        $this->suppliers = new SupplierRepository( new Supplier() );
        $this->accountNatures = new AccountingRepository( new AccountsNature() );
        $this->practiceTaxation = new PracticeRepository( new PracticeTaxation() );
    }

    public function create(Request $request){

        $http_resp = $this->http_response['200'];
        $rule = [
            'amount'=>'required',
            'account_id'=>'required',
            'reason'=>'required',
            'as_at'=>'required',
        ];
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        if($request->amount==0){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ['New opening balance cannot be zero!'];
            return response()->json($http_resp,422);
        }

        $income_ledger_code = AccountsCoa::AC_INVENTORY_CODE;
        $ac_payable_code = AccountsCoa::AC_PAYABLE_CODE;
        $ac_receivable_code = AccountsCoa::AC_RECEIVABLE_CODE;
        $ac_inventory_code = AccountsCoa::AC_INVENTORY_CODE;
        $user = $request->user();
        $company = $this->practices->find($user->company_id);
        $inputs = $request->except(['account_id']);
        $chartOfAccount = $this->chartOfAccounts->findByUuid($request->account_id);
        $op_balance = $chartOfAccount->openingBalances()->get()->first();
        //Log::info($op_balance);
        $account_type = $chartOfAccount->account_types()->get()->first();
        $accounts_nature = $account_type->accounts_natures()->get()->first();
        $ac_code = $chartOfAccount->default_code;
        //Check if Account Type is Receivable or Payable
        if( $ac_code==$ac_receivable_code || $ac_code==$ac_payable_code ){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ["Choose a non '".$account_type->name."' account for your deposit!"];
            return response()->json($http_resp,422);
        }
        //Check if is Inventory/Purchase account
        if( $ac_code==$ac_inventory_code ){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ["Choose a non Inventory account for your deposit!"];
            return response()->json($http_resp,422);
        }
        $trans_type = AccountsCoa::TRANS_TYPE_OPENING_BALANCE;
        $open_balance_equity_ledger_code = AccountsCoa::AC_OPENING_BALANCE_EQUITY_CODE;
        $open_balance_ldeger_account = $company->chart_of_accounts()
            ->where('default_code',$open_balance_equity_ledger_code)
            ->where('is_special',true)
            ->get()
            ->first();

        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{
            if($accounts_nature->name == AccountsCoa::ASSETS){
                //Assets : [Dr | Cr]==["New Ac" - "Opening Balance Equity"] Transaction is called "Opening Balance"
                //Perform Double Entry
                $debited_ac = $chartOfAccount->code;
                $credited_ac = $open_balance_ldeger_account->code;
            }elseif($accounts_nature->name==AccountsCoa::EQUITY || $accounts_nature->name==AccountsCoa::LIABILITY){
                $debited_ac = $open_balance_ldeger_account->code;
                $credited_ac = $chartOfAccount->code;
            }

            if($op_balance){
                //Get Ledger Support Document
                $op_balance->update($inputs);
                $supportDoc = $op_balance->double_entry_support_document()->get()->first();
                //Get Journal Entry
                $journalEntry = $supportDoc->journalEntries()->get()->first();
                $journalEntry->amount = $request->amount;
                $journalEntry->save();
            }else{
                $amount = $request->amount;
                $as_of = $this->helper->format_lunox_date($request->as_at);
                $trans_name = "Account ".$trans_type;
                $transaction_id = $this->helper->getToken(10,'INV');
                $op_balance = $company->accountOpeningBalances()->create($inputs);
                $op_balance = $chartOfAccount->openingBalances()->save($op_balance);
                $supportDocument = $op_balance->double_entry_support_document()->create(['trans_type'=>$trans_type]);
                $double_entry = $this->accountingVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_of,$trans_name,$transaction_id);
                $double_entry->supports()->save($supportDocument);
            }
            $http_resp['description'] = "Account balance successful adjusted!";

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        return response()->json($http_resp);

    }
}

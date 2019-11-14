<?php

namespace App\Accounting\Repositories;

use App\Accounting\Models\Banks\AccountMasterBank;
use App\Accounting\Models\Banks\AccountMasterBankBranch;
use App\Accounting\Models\Banks\AccountsBank;
use Illuminate\Database\Eloquent\Model;
use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsType;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\COA\AccountsHolder;
use App\Accounting\Models\COA\AccountsNature;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\helpers\HelperFunctions;
use App\Models\Module\Module;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Accounting\Models\Payments\AccountPaymentType;

class AccountingRepository implements AccountingRepositoryInterface
{
    protected $model;
    protected $helpers;

    public function __construct( Model $model )
    {
        $this->model = $model;
        $this->helpers = new HelperFunctions();
    }

    public function all(){
        return $this->model->all()->sortBy('name');
    }
    public function find($id){
        return $this->model->find($id);
    }
    public function findByUuid($uuid){
        return $this->model->all()->where('uuid',$uuid)->first();
    }
    public function findByCode($code){
        return $this->model->all()->where('code',$code)->first();
    }
    public function create($inputs = []){
        return $this->model->create($inputs);
    }

    public function account_statement(Model $company, AccountsHolder $accountsHolder){


        $date_range = $this->helpers->get_default_date_range();
        $opening_balance = 0;
        $billed_amount = 0;
        $paid_amount = 0;
        $transactions = array();

        //Get Opening balance transactions
        $op_balances = $accountsHolder->supports()->where('trans_type',AccountsCoa::TRANS_TYPE_OPENING_BALANCE)->get();
        foreach( $op_balances as $op_balance ){
            $journal_entry = $op_balance->vouchers()->get()->first();
            $opening_balance += $journal_entry->amount;
        }

        return [
            'id'=>$accountsHolder->uuid,
            'account_type'=>$accountsHolder->account_type,
            'account_number'=>$accountsHolder->account_number,
            'name'=>$accountsHolder->name,
            'main'=>$accountsHolder->main,
            'balance'=>$accountsHolder->balance,
            'opening_balance'=>$opening_balance,
            'billed_amount'=>$billed_amount,
            'paid_amount'=>$paid_amount,
            'bonus'=>$accountsHolder->bonus,
            'date_range'=>$date_range,
            'transactions' => $transactions,
        ];

    }

    // public function transform_bank_accounts(AccountsBank $accountsBank){

    //     $account_type = $accountsBank->account_types()->get()->first();
    //     $acc_type['id'] = $account_type->uuid;
    //     $acc_type['name'] = $account_type->name;
    //     $banker = $accountsBank->bank()->get()->first();
    //     $bank['id'] = $banker->uuid;
    //     $bank['name'] = $banker->name;
    //     $banker_branch = $accountsBank->bank_branch()->get()->first();
    //     $bank_branch['id'] = $banker_branch->id;
    //     $bank_branch['code'] = $banker_branch->code;
    //     $bank_branch['name'] = $banker_branch->name;
    //     return [
    //         'id'=>$accountsBank->uuid,
    //         'account_name'=>$accountsBank->account_name,
    //         'account_number'=>$accountsBank->account_number,
    //         'balance'=>$accountsBank->balance,
    //         'status'=>$accountsBank->status,
    //         'account_type'=>$acc_type,
    //         'bank'=>$bank,
    //         'bank_branch'=>$bank_branch,
    //     ];
    // }

    // public function transform_bank(AccountMasterBank $accountMasterBank){
    //     return [
    //         'id'=>$accountMasterBank->uuid,
    //         'name'=>$accountMasterBank->name,
    //         'description'=>$accountMasterBank->description,
    //         'phone'=>$accountMasterBank->phone,
    //         'address'=>$accountMasterBank->address,
    //         'email'=>$accountMasterBank->email,
    //         'code'=>$accountMasterBank->code,
    //         'comments'=>$accountMasterBank->comments,
    //     ];
    // }

    // public function transform_bank_branch( AccountMasterBankBranch $accountMasterBankBranch ){

    //     $bank = $accountMasterBankBranch->bank()->get()->first();
    //     return [
    //         'id' => $accountMasterBankBranch->uuid,
    //         'name' => $accountMasterBankBranch->name,
    //         'code' => $accountMasterBankBranch->code,
    //         'address' => $accountMasterBankBranch->address,
    //         'bank' => $this->transform_bank($bank),
    //     ];

    // }

    public function transform_payment_type(AccountPaymentType $accountPaymentType){
        return [
            'id'=>$accountPaymentType->uuid,
            'name'=>$accountPaymentType->name,
            'description' => $accountPaymentType->description
        ];
    }
    // public function getDefaultCoa(){
    //     return $this->model->all()->where('sys_default',true);//->sortBy(name);
    // }

    public function transform_company_chart_of_account(AccountChartAccount $accountChartAccount){
        //Get details from system default Chart of Accounts
        $default_coa = $accountChartAccount->coas()->get()->first();
        //Get Account Type
        $account_type = $default_coa->account_types()->get()->first();
        $total_debited = $accountChartAccount->debited_vouchers()->sum('amount');
        $total_credited = $accountChartAccount->credited_vouchers()->sum('amount');
        $bal['state'] = 0;
        $bal['balance'] = 0;
        if( $total_debited == $total_credited ){
            $bal['state'] = 0;
            $bal['balance'] = 0;
        }elseif( ($total_debited - $total_credited) > 0 ){
            $bal['state'] = 1;
            $bal['balance'] = $total_debited - $total_credited;
        }else{
            $bal['state'] = -1;
            $bal['balance'] = $total_credited - $total_debited;
        }
        return [
            'id'=>$accountChartAccount->uuid,
            'name' => $accountChartAccount->name,
            'code' => $accountChartAccount->code,
            'default_code' => $accountChartAccount->default_code,
            'is_sub_account' => $accountChartAccount->is_sub_account,
            'is_special' => $accountChartAccount->is_special,
            'description' => $accountChartAccount->description,
            'balance_obj' => $bal,
            'default_coa' => $this->transform_default_coa($default_coa),
            'account_type' => $this->transform_account_type($account_type),
            'tax_rate' => '',
            'status' => $accountChartAccount->status,
            'notes' => $accountChartAccount->notes,
        ];
    }

    public function transform_account_type(AccountsType $accountsType){

        $accounts_nature = $accountsType->accounts_natures()->get()->first();
        return [
            'id'=>$accountsType->uuid,
            'name'=>$accountsType->name,
            'accounts_nature' => $this->transform_account_nature($accounts_nature),
        ];

    }

    public function transform_account_nature(AccountsNature $accountsNature){
        return [
            'id'=>$accountsNature->id,
            'name'=>$accountsNature->name,
        ];
    }

    public function transform_default_coa(AccountsCoa $accountsCoa){

        $account_type = $accountsCoa->account_types()->get()->first();
        return [
            'id'=>$accountsCoa->uuid,
            'name'=>$accountsCoa->name,
            'code'=>$accountsCoa->code,
            'account_type' => $this->transform_account_type($account_type)
        ];
    }

    public function accounts_double_entry(Model $company ,$debited_code, $credited_code,$amount,$trans_date,$notes,$transaction_id){
        //Create a double entry transaction
        $credited_parent = 0;
        $debited_parent = 0;
        $cr_ac = AccountChartAccount::where('code',$credited_code)->get()->first();
        if($cr_ac->is_sub_account){
            $credited_parent = $cr_ac->coas()->get()->first()->code;
        }
        $dr_ac = AccountChartAccount::where('code',$debited_code)->get()->first();
        if($dr_ac->is_sub_account){
            $debited_parent = $dr_ac->coas()->get()->first()->code;
        }

        $double_entry = $this->model->create([
            'credited'=>$credited_code,
            'debited'=>$debited_code,
            'amount'=>$amount,
            'voucher_date'=>$trans_date,
            'notes'=>$notes,
            'transaction_id'=>$transaction_id,
            'debited_parent'=>$debited_parent,
            'credited_parent'=>$credited_parent,
        ]);
        //Link it to a company
        $double_entry = $company->vouchers()->save($double_entry);
        return $double_entry;
    }

    public function create_journal_report(AccountsVoucher $accountsVoucher){
        /*
            General journal is a daybook or journal which is used to record transactions
             relating to adjustment entries, opening stock, accounting errors etc. 
             The source documents of this prime entry book are journal voucher,
              copy of management reports and invoices.
        */
        $double_entries = array();
        array_push($double_entries,$this->transform_journal_entry($accountsVoucher,AccountsCoa::BALANCE_DEBIT));
        array_push($double_entries,$this->transform_journal_entry($accountsVoucher,AccountsCoa::BALANCE_CREDIT));
        return $double_entries;
    }

    public function create_general_ledger(Model $company){
        /*
            A general ledger (GL) is a set of numbered accounts a business uses
             to keep track of its financial transactions and to prepare financial
              reports. Each account is a unique record summarizing each type of asset,
               liability, equity, revenue and expense. A chart of accounts lists
                all of the accounts in the general ledger, which can number in the
                 thousands for a large business.
        */

        /*
        ASSET and EXPENSE accounts have normal debit balances. This means that
         when the account increases, the amount is posted as a debit. When the
          balance decreases, a credit is posted. Liability, equity and revenue
           accounts have normal credit balances. When these accounts increase,
            a credit is posted. When they decrease, a debit is posted.
        */

        /*
        Asset accounts are those that track things of value and
         include accounts such as cash, supplies, prepaid insurance,
          land and buildings. Expense accounts are used to track
           how much a company spends on various types of expenses.
            Expense accounts include repairs, utilities and insurance.
        */

        /*
        Calculate asset and expense account balances. These types of accounts
         have debit balances. To calculate the balance in these types, start
          with the beginning debit balance in the account. Add any additional 
          debits made to the account and subtract any credit postings. This calculation
           represents the current balance in the account.
        */

        /*
        Learn what liabilities, equities and revenues are. Liabilities are accounts
         that track amounts of money owed to others. Equity accounts track the amount
          of money each business owner possesses individually. For example, if a
           business has three owners, each has his own equity account. The amount
            in each owner's account represents that individual business owner's investment
             in the company. This amount is the portion of the business that particular
              owner has rights to. Revenue accounts track the amount of money a
               company earns. These accounts all have normal credit balances.
        */

        /*
            Calculate liability, equity and revenue account balances. 
            Because these accounts have credit balances, to calculate the 
            current balance, start with the beginning credit amount. Add any 
            credit posting made to the account and subtract any debit postings.
            After completing this, you have calculated the current balance of an account.
        */
        $report = array();
        $account_natures = AccountsNature::all();
        foreach ($account_natures as $account_nature ) {

            $temp['id'] = $account_nature->id;
            $temp['nature_type'] = $account_nature->name;
            $accounts_under_nature = array();
            //Get account type of this nature
            $account_types = $account_nature->account_types()->get();
            foreach ($account_types as $account_type) {
                //Get default accounts under this type
                $default_accounts = $account_type->default_accounts()->get();
                foreach ($default_accounts as $default_account) {
                    //Get Company Chart of Accounts Under this default account
                    // $company_chart_accounts = $default_account->chart_of_accounts()->get();
                    $temp_main['id'] = $default_account->uuid;
                    $temp_main['name'] = $default_account->name;
                    $company_chart_accounts = $company->chart_of_accounts()
                    ->where('default_coa_id',$default_account->id)
                    ->where('is_sub_account',false)
                    ->get();
                    $accounts = array();
                    foreach ($company_chart_accounts as $company_chart_account) {

                        $temp_account['id'] = $company_chart_account->uuid;
                        $temp_account['name'] = $company_chart_account->name;
                        $temp_account['is_sub_account'] = $company_chart_account->is_sub_account;
                        $temp_account['status'] = $company_chart_account->status;
                        $temp_account['notes'] = $company_chart_account->notes;
                        $temp_account['code'] = $company_chart_account->code;
                        //Get and process vouchers activities that has happened on this account
                        $transactions = array();
                        $vouchers = DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->table('accounts_vouchers')
                                        ->where('credited',$company_chart_account->code)
                                        ->orWhere('debited',$company_chart_account->code)
                                        ->orWhere('credited_parent',$company_chart_account->code)
                                        ->orWhere('debited_parent',$company_chart_account->code)
                                        ->get();
                        $account_balance = $vouchers->count();
                        foreach ($vouchers as $vouche) {
                            $voucher = AccountsVoucher::find($vouche->id);
                            $temp_trans['debit'] = $this->transform_journal_entry($voucher,AccountsCoa::BALANCE_DEBIT);
                            $temp_trans['credit'] = $this->transform_journal_entry($voucher,AccountsCoa::BALANCE_CREDIT);
                            array_push($transactions,$temp_trans);
                        }
                        $temp_account['transactions'] = $transactions;
                        if($account_balance>0){
                            array_push($accounts_under_nature,$temp_account);
                        }
                    }
                    $temp_main['company_chart_account'] = $accounts;
                }
            }
            $temp['accounts'] = $accounts_under_nature;

            array_push($report,$temp);
        }
        return $report;
    }

    public function create_trail_balance(Model $company){

        /*
            DEBIT_SIDE = Assets + Expenses + Drawings
            CREDIT_SIDE = Liabilities + Revenue + Owners Equity
        */

        /*
            Well, as you know, accounting/bookkeeping is all about balancing. 
            The accounting equation needs to balance, every transaction needs 
            to be balanced, our debits and credits need to be balanced and so on.

            A trial balance is the accounting equation of our business laid out 
            in detail. It has our assets, expenses and drawings on the left (the debit side) 
            and our liabilities, revenue and owner’s equity on the right (the credit side). 
            We can see everything clearly and make sure it all balances.

            A trial balance that balances tells us that we’ve done all our journals and 
            ledgers correctly. it’s saying, “All your transactions for the year have 
            been entered, and, everything looks right!”
        */

        $report = array();
        $account_natures = AccountsNature::all();
        foreach ($account_natures as $account_nature ) {

            $temp['id'] = $account_nature->id;
            $temp['nature_type'] = $account_nature->name;
            $accounts_under_nature = array();
            //Get account type of this nature
            $account_types = $account_nature->account_types()->get();
            foreach ($account_types as $account_type) {
                //Get default accounts under this type
                $default_accounts = $account_type->default_accounts()->get();
                foreach ($default_accounts as $default_account) {
                    //Get Company Chart of Accounts Under this default account
                    // $company_chart_accounts = $default_account->chart_of_accounts()->get();
                    $temp_main['id'] = $default_account->uuid;
                    $temp_main['name'] = $default_account->name;
                    $company_chart_accounts = $company->chart_of_accounts()
                    ->where('default_coa_id',$default_account->id)
                    //->where('is_sub_account',false)
                    ->get();
                    $accounts = array();
                    foreach ($company_chart_accounts as $company_chart_account) {

                        $temp_account['id'] = $company_chart_account->uuid;
                        $temp_account['name'] = $company_chart_account->name;
                        $temp_account['is_sub_account'] = $company_chart_account->is_sub_account;
                        $temp_account['status'] = $company_chart_account->status;
                        $temp_account['notes'] = $company_chart_account->notes;
                        $temp_account['code'] = $company_chart_account->code;
                        $temp_account['nature_type'] = $this->transform_account_nature($account_nature);
                        //Get and process vouchers activities that has happened on this account
                        $transactions = array();
                        $vouchers = DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->table('accounts_vouchers')
                                        ->where('credited',$company_chart_account->code)
                                        ->orWhere('debited',$company_chart_account->code)
                                        //->orWhere('credited_parent',$company_chart_account->code)
                                        //->orWhere('debited_parent',$company_chart_account->code)
                                        ->get();
                        $account_balance = $vouchers->count();
                        foreach ($vouchers as $vouche) {
                            $voucher = AccountsVoucher::find($vouche->id);
                            $temp_trans['debit'] = $this->transform_journal_entry($voucher,AccountsCoa::BALANCE_DEBIT);
                            $temp_trans['credit'] = $this->transform_journal_entry($voucher,AccountsCoa::BALANCE_CREDIT);
                            array_push($transactions,$temp_trans);
                        }
                        $temp_account['transactions'] = $transactions;
                        if($account_balance>0){
                            array_push($report,$temp_account);
                        }
                        
                    }
                    //$temp_main['company_chart_account'] = $accounts;
                }
            }
            //$temp['accounts'] = $accounts_under_nature;

            //array_push($report,$temp);
        }
        return $report;
    }

    public function create_balance_sheet(Model $company){

        /*
            The balance sheet displays the company’s total assets, and how these assets are financed,
             through either debt or equity. It can also be referred to as a statement of net worth, 
             or a statement of financial position. The balance sheet is based on the fundamental 
             equation: Assets = Liabilities + Equity.
             Total Assets = Current Assets + Non-current Assets
             Total Liability = Current Liability + Non-current Liability
             Total Equity = Share Capital + Retained Earning


             The left side of the balance sheet outlines all a company’s assets. On the right side, 
             the balance sheet outlines the companies liabilities and shareholders’ equity. On either 
             side, the main line items are generally classified by liquidity. More liquid accounts 
             such as Inventory, Cash, and Trades Payables are placed before illiquid accounts such 
             as Plant, Property, and Equipment (PP&E) and Long-Term Debt. The assets and liabilities
              are also separated into two categories: current asset/liabilities and non-current
               (long-term) assets/liabilities.

        */
        $report = array();
        $account_natures = AccountsNature::where('name',AccountsCoa::ASSETS)
            ->orWhere('name',AccountsCoa::LIABILITY)->orWhere('name',AccountsCoa::EQUITY)->get();
        foreach ($account_natures as $account_nature ) {

            $temp['id'] = $account_nature->id;
            $temp['nature_type'] = $account_nature->name;
            $temp_type_account = array(); //--------------------------------------------------------------
            //$accounts_under_nature = array();
            //Get account type of this nature
            $account_types = $account_nature->account_types()->get();
            Log::info($account_types);
            foreach ($account_types as $account_type) {

                $temp_types = $this->transform_account_type($account_type);
                //Get company chart of accounts under this account type
                $accounts = $company->chart_of_accounts()->where('accounts_type_id',$account_type->id)->get();
                $account_array = array();
                foreach ($accounts as $company_chart_account) {
                    $temp_account['id'] = $company_chart_account->uuid;
                    $temp_account['name'] = $company_chart_account->name;
                    $temp_account['is_sub_account'] = $company_chart_account->is_sub_account;
                    $temp_account['status'] = $company_chart_account->status;
                    $temp_account['notes'] = $company_chart_account->notes;
                    $temp_account['code'] = $company_chart_account->code;
                    $temp_account['nature_type'] = $this->transform_account_nature($account_nature);
                    //Get and process vouchers activities that has happened on this account
                    $transactions = array();
                    $vouchers = DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->table('accounts_vouchers')
                                    ->where('credited',$company_chart_account->code)
                                    ->orWhere('debited',$company_chart_account->code)
                                    //->orWhere('credited_parent',$company_chart_account->code)
                                    //->orWhere('debited_parent',$company_chart_account->code)
                                    ->get();
                    $account_balance = $vouchers->count();
                    foreach ($vouchers as $vouche) {
                        $voucher = AccountsVoucher::find($vouche->id);
                        $temp_trans['debit'] = $this->transform_journal_entry($voucher,AccountsCoa::BALANCE_DEBIT);
                        $temp_trans['credit'] = $this->transform_journal_entry($voucher,AccountsCoa::BALANCE_CREDIT);
                        array_push($transactions,$temp_trans);
                    }
                    $temp_account['transactions'] = $transactions;
                    if($account_balance > 0){
                        array_push($account_array,$temp_account);
                    }
                    //array_push($account_array,$temp_account);
                }
                $temp_types['accounts'] = $account_array;
                array_push($temp_type_account,$temp_types);
            }
            $temp['account_types'] = $temp_type_account;
            array_push($report,$temp);
        }
        return $report;
    }

    public function transform_journal_entry(AccountsVoucher $accountsVoucher, $journal_type=AccountsCoa::BALANCE_DEBIT){

        $transaction_type = "";
        $transaction_name = "";
        $helper = new HelperFunctions();
        $debit = array();
        //Get support Document
        $support_document = $accountsVoucher->support_documents()->get()->first();
        if($support_document){
            $transaction_type = $support_document->trans_type;
            $transaction_name = $support_document->trans_name;
        }
        switch ($journal_type) {
            case AccountsCoa::BALANCE_CREDIT :
                $debit_account = $accountsVoucher->credited()->get()->first(); //default system account
                $account_type = $debit_account->account_types()->get()->first();
                $account_nature = $account_type->accounts_natures()->get()->first();
                $debit['balance_type'] = AccountsCoa::BALANCE_CREDIT;
                $debit['name'] = $debit_account->name;
                $debit['code'] = $debit_account->code;
                $debit['custom_name'] = $debit_account->name;
                $debit['custom_code'] = $debit_account->code;
                $debit['credited_parent'] = $accountsVoucher->credited_parent;
                $debit['debited_parent'] = $accountsVoucher->debited_parent;
                $debit['amount'] = $accountsVoucher->amount;
                $debit['trans_date'] = $helper->format_mysql_date($accountsVoucher->voucher_date,"jS M Y");
                $debit['trans_type'] = $transaction_type;
                $debit['trans_name'] = $transaction_name;
                $debit['trans_description'] = $transaction_name;
                $debit['total_balance'] = 0;
                $debit['is_sub_account'] = $debit_account->is_sub_account;
                $debit['account_nature'] = $this->transform_account_nature($account_nature);
                break;
            
            default:
                $debit_account = $accountsVoucher->debited()->get()->first(); //default system account
                //Log::info($debit_account);
                $account_type = $debit_account->account_types()->get()->first();
                //Log::info($account_type);
                $account_nature = $account_type->accounts_natures()->get()->first();
                //Log::info($account_nature);
                $debit['balance_type'] = AccountsCoa::BALANCE_DEBIT;
                $debit['name'] = $debit_account->name;
                $debit['code'] = $debit_account->code;
                $debit['custom_name'] = $debit_account->name;
                $debit['custom_code'] = $debit_account->code;
                $debit['credited_parent'] = $accountsVoucher->credited_parent;
                $debit['debited_parent'] = $accountsVoucher->debited_parent;
                $debit['amount'] = $accountsVoucher->amount;
                $debit['trans_date'] = $helper->format_mysql_date($accountsVoucher->voucher_date,"jS M Y");
                $debit['trans_type'] = $transaction_type;
                $debit['trans_name'] = $transaction_name;
                $debit['trans_description'] = $transaction_name;
                $debit['total_balance'] = 0;
                $debit['is_sub_account'] = $debit_account->is_sub_account;
                $debit['account_nature'] = $this->transform_account_nature($account_nature);
                break;
        }
        return $debit;
    }

    public function company_coa_initialization(Model $company){

        $coas = AccountsCoa::all()->where('sys_default',true)->where('owning_id','')->where('owning_type','');
        foreach( $coas as $coa ){
            //Create company's COA in AccountsCOA
            $inputs['name'] = $coa->name;
            $inputs['code'] = $coa->code.'0000'.$company->id;
            $inputs['accounts_type_id'] = $coa->accounts_type_id;
            $inputs['sys_default'] = true;
            $inputs['is_special'] = false;
            //Create account in itself
            $default_account = AccountsCoa::create($inputs);
            //Link above account to a company
            $default_account = $company->coas()->save($default_account);
            $inputs2['name'] = $coa->name;
            $inputs2['code'] = $coa->code.'0000'.$company->id;
            $inputs2['accounts_type_id'] = $coa->accounts_type_id;
            $inputs2['default_code'] = $coa->code;
            $inputs2['is_special'] = true;
            //Create this company default&special account in debitable,creditable table
            $debitable_creditable_ac = $default_account->chart_of_accounts()->create($inputs2);//This also links it to parent default account
            //Link above debitable_creditable_ac account to a company
            $debitable_creditable_ac = $company->chart_of_accounts()->save($debitable_creditable_ac);
        }
    }

    public function company_payment_initialization(Model $company){

        $company->accounts_payment_methods()->create(['name'=>'Cash']);
        $company->accounts_payment_methods()->create(['name'=>'Cheque']);
        $company->accounts_payment_methods()->create(['name'=>'Credit Card']);
        $company->accounts_payment_methods()->create(['name'=>'Direct Debit']);

    }

} 
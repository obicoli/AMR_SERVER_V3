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
use App\Accounting\Models\Voucher\AccountsSupport;
use App\Customer\Models\Customer;
use App\Customer\Repositories\CustomerRepository;
use App\Models\Practice\Practice;

class AccountingRepository implements AccountingRepositoryInterface
{
    protected $model;
    protected $helpers;
    protected $customerRepository;

    public function __construct( Model $model )
    {
        $this->model = $model;
        $this->helpers = new HelperFunctions();
        $this->customerRepository = new CustomerRepository(new Customer());
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
    public function findByName($name){
        return $this->model->all()->where('name',$name)->first();
    }
    public function findByDefaultCode($code){
        return $this->model->all()->where('default_code',$code)->first();
    }
    public function create($inputs = []){
        return $this->model->create($inputs);
    }

    public function create_chart_of_account(Practice $company, AccountsCoa $accountsCoa, $inputs, Model $account_owner){

        //(B). CREATING BANKS LEDGER ACCOUNT: 4 Steps
        //Step 1. Find Default Bank(Bank balances) account
        //$default_bank_coa = $this->accountsCoa->findByCode(AccountsCoa::AC_BANK_CODE);
        //Step 2. Create Bank's Legder Account in AccountsCoa
        //$inpos['name'] = $request->account_name;
        //$inpos['code'] = $default_bank_coa->code.'0000'.$facility->id;
        $inputs['code'] = $account_owner->id.'00'.$accountsCoa->code.'00'.$company->id;
        $inputs['accounts_type_id'] = $accountsCoa->accounts_type_id;
        $inputs['sys_default'] = true;
        $inputs['is_special'] = false;
        $default_account = AccountsCoa::create($inputs);
        //Link above account to company
        $default_account = $company->coas()->save($default_account);
        //Step 3. Create this company default&special account in debitable,creditable table
        $inputs2['name'] = $inputs['name'];
        $inputs2['code'] = $account_owner->id.'00'.$accountsCoa->code.'00'.$company->id;
        $inputs2['accounts_type_id'] = $accountsCoa->accounts_type_id;
        $inputs2['default_code'] = $accountsCoa->code;
        $inputs2['is_special'] = true;
        $custom_chart_of_coa = $default_account->chart_of_accounts()->create($inputs2);//This also links it to parent default account
        //Link above debitable_creditable_ac account to a company
        $custom_chart_of_coa = $company->chart_of_accounts()->save($custom_chart_of_coa);
        //Step 4. Link bank account to Ledger
        //$bank_ledger_ac = $custom_chart_of_coa->bank_accounts()->save($account_owner);
        $account_owner->ledger_account_id = $custom_chart_of_coa->id;
        $account_owner->save();
        return $custom_chart_of_coa;

    }
    public function create_sub_chart_of_account(Practice $company, AccountChartAccount $mainAccount, $inputs=[],Model $account_owner){
        $default_coa = $mainAccount->coas()->get()->first();
        $inputs['accounts_type_id'] = $mainAccount->accounts_type_id;
        $inputs['code'] = $this->helpers->getAccountNumber();
        $inputs['default_coa_id'] = $default_coa->id;
        $inputs['is_sub_account'] = true;
        $inputs['default_code'] = $mainAccount->default_code;
        $custom_chart_of_coa = AccountChartAccount::create($inputs);
        $custom_chart_of_coa = $company->chart_of_accounts()->save($custom_chart_of_coa);

        //$custom_chart_of_coa->bank_accounts()->save($account_owner);
        $account_owner->ledger_account_id = $custom_chart_of_coa->id;
        $account_owner->save();

        return $custom_chart_of_coa;
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

    public function calculate_account_balance(AccountChartAccount $accountChartAccount, $filters=[] ){
        /*
         Calculate asset and expense account balances. These types of accounts
         have debit balances. To calculate the balance in these types, start
          with the beginning debit balance in the account. Add any additional 
          debits made to the account and subtract any credit postings. This calculation
           represents the current balance in the account.
        */

        $debited_total = $accountChartAccount->debited_vouchers()->sum('amount');
        $credited_total = $accountChartAccount->credited_vouchers()->sum('amount');
        $account_type = $accountChartAccount->account_types()->get()->first();
        $account_nature = $account_type->accounts_natures()->get()->first();

        $debit_parent_balance = $accountChartAccount->debited_parent_vouchers()->sum('amount');
        $credited_parent_total = $accountChartAccount->credited_parent_vouchers()->sum('amount');
        
        if( $account_nature->name == AccountsCoa::ASSETS || $account_nature->name == AccountsCoa::EXPENSE ){
            return ($debited_total+$debit_parent_balance) - ($credited_total+$credited_parent_total);
        }else{
            return ($credited_total+$credited_parent_total) + ($debited_total+$debit_parent_balance);
        }
        /*
            Calculate liability, equity and revenue account balances. 
            Because these accounts have credit balances, to calculate the 
            current balance, start with the beginning credit amount. Add any 
            credit posting made to the account and subtract any debit postings.
            After completing this, you have calculated the current balance of an account.
        */
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

    public function transform_company_chart_of_account(AccountChartAccount $accountChartAccount, $detailed_report=null, $filters=[]){
        //Get details from system default Chart of Accounts
        $default_coa = $accountChartAccount->coas()->get()->first();
        //Get Account Type
        $account_type = $default_coa->account_types()->get()->first();
        $balance = $this->calculate_account_balance($accountChartAccount);
        $company = $accountChartAccount->owning()->get()->first();
        $transactions = [];
        if($detailed_report){
            if( sizeof($filters) ){
            }else{
                $filters = $this->helpers->get_default_filter();
                $double_entries = DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)
                    ->table('accounts_vouchers')
                    ->where('credited', $accountChartAccount->code)
                    ->orWhere('debited', $accountChartAccount->code)
                    ->orWhere('credited_parent', $accountChartAccount->code)
                    ->orWhere('debited_parent', $accountChartAccount->code)
                    ->whereBetween('created_at', [$filters['start'], $filters['end']])
                    ->get();
                foreach( $double_entries as $double_entry ){
                    $double_entr = AccountsVoucher::find($double_entry->id);
                    array_push($transactions,$this->transform_journal_entry($double_entr,AccountsCoa::ACCOUNT_TRANSACTION_REPORT,$company));
                }
            }
        }

        return [
            'id'=>$accountChartAccount->uuid,
            'name' => $accountChartAccount->name,
            'code' => $accountChartAccount->code,
            'default_code' => $accountChartAccount->default_code,
            'is_sub_account' => $accountChartAccount->is_sub_account,
            'is_special' => $accountChartAccount->is_special,
            'description' => $accountChartAccount->description,
            'balance' => $balance,
            'filters' => $filters,
            'default_coa' => $this->transform_default_coa($default_coa),
            'account_type' => $this->transform_account_type($account_type),
            'tax_rate' => '',
            'status' => $accountChartAccount->status,
            'notes' => $accountChartAccount->notes,
            'transactions' => $transactions,
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

    public function transform_support_document(AccountsSupport $accountsSupport,Model $company=null){
        
        //$transactionable = $accountsSupport->transactionable()->get()->first();
        return [
            'id' => $accountsSupport->uuid,
            'trans_type' => $accountsSupport->trans_type,
            'trans_name' => $accountsSupport->trans_name,
            'reference_number' => $accountsSupport->reference_number,
        ];
    }

    public function accounts_double_entry(Model $company ,$debited_code, $credited_code,$amount,$trans_date,$notes,$transaction_id){
        //Create a double entry transaction
        /*
            When using this function to perform double entry
            1. Must Provide Company model
            2. Debited Account Code Should come first
            3. Then followed by Credited Account Code
        */
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
          balance decreases, a credit is posted. LIABILITY, EQUITY and REVENUE
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

    public function transform_journal_entry(AccountsVoucher $accountsVoucher, $journal_type=AccountsCoa::BALANCE_DEBIT,Model $company=null){

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
            case AccountsCoa::ACCOUNT_TRANSACTION_REPORT: //This transform Double Entry Based on selected "Chart of Account" & Give "Account Transactional Report" Inputs
                
                $trans_with['id'] = '';
                $trans_with['name'] = '';
                $support_type = $support_document->trans_type;
                $transactionable = $support_document->transactionable()->get()->first();
                
                if($support_type==AccountsCoa::TRANS_TYPE_CUSTOMER_OPENING_BALANCE || $support_type==AccountsCoa::TRANS_TYPE_SUPPLIER_OPENING_BALANCE){
                    if($transactionable){
                        $trans_with['id'] = $transactionable->id;
                        $trans_with['name'] = $transactionable->legal_name;
                    }
                }elseif($support_type == AccountsCoa::TRANS_TYPE_ACCOUNT_OPENING_BALANCE){
                    $trans_with['id'] = $transactionable->id;
                    $trans_with['name'] = $transactionable->account_name;
                }elseif( $support_type == AccountsCoa::TRANS_TYPE_CUSTOMER_RECEIPT || $support_type==AccountsCoa::TRANS_TYPE_DISCOUNT_ALLOWED ){
                    $customer_account = $support_document->account_holders()->get()->first();
                    $customer = $customer_account->owner()->get()->first();
                    $trans_with['id'] = $customer->id;
                    $trans_with['name'] = $customer->legal_name;
                    $trans_with['customer'] = $this->customerRepository->transform_customer($customer);
                }

                $double_entry['debited'] = $accountsVoucher->debited;
                $double_entry['credited'] = $accountsVoucher->credited;
                $double_entry['debited_parent'] = $accountsVoucher->debited_parent;
                $double_entry['credited_parent'] = $accountsVoucher->credited_parent;
                $double_entry['amount'] = $accountsVoucher->amount;

                $debit['id'] = $accountsVoucher->uuid;
                $debit['notes'] = $accountsVoucher->notes;
                $debit['amount'] = $accountsVoucher->amount;
                $debit['trans_with'] = $trans_with;
                $debit['double_entry'] = $double_entry;
                $debit['support_document'] = $this->transform_support_document($support_document);
                $debit['trans_date'] = $helper->format_mysql_date($accountsVoucher->voucher_date,$company->date_format);
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
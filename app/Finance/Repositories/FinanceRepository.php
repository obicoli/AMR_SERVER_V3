<?php

namespace App\Finance\Repositories;

use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Repositories\AccountingRepository;
use App\Customer\Repositories\CustomerRepository;
use App\Finance\Models\Banks\AccountBankAccountType;
use Illuminate\Database\Eloquent\Model;
use App\Finance\Models\Banks\AccountMasterBank;
use App\Finance\Models\Banks\AccountMasterBankBranch;
use App\Finance\Models\Banks\AccountsBank;
use App\Finance\Models\Banks\BankReconciliation;
use App\Finance\Models\Banks\BankTransaction;
use App\helpers\HelperFunctions;
use App\Models\Account\Customer\Customer;
use App\Models\Practice\Practice;
use App\Repositories\Practice\PracticeRepository;
use Illuminate\Support\Facades\Log;

class FinanceRepository implements FinanceRepositoryInterface
{

    protected $model;
    protected $helpers;
    protected $customerRepository;
    protected $accountingRepository;
    protected $companyUser;

    public function __construct( Model $model )
    {
        $this->model = $model;
        $this->helpers = new HelperFunctions();
        $this->customerRepository = new CustomerRepository(new Customer());
        $this->accountingRepository = new AccountingRepository(new AccountsCoa());
        $this->companyUser = new PracticeRepository( new Practice() );
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

    public function delete($id){
        return $this->model->find($id)->delete();
    }

    public function update(array $arr, $id){
        return $this->model->find($id)->update($arr);
    }

    public function getOrCreateBankReconciliation(AccountsBank $accountsBank, $start_date, $inputs=[]){

        //This function will be used to get Bank Reconciliation that has not been closed( i.e Whose newly created transactions are attached to)
        $open_bank_reconciliation = $accountsBank->bank_reconciliations()->where('status',AccountsCoa::RECONCILIATION_NOT_TICKED)->get()->first();
        if($open_bank_reconciliation){
            return $open_bank_reconciliation;
        }else{
            return $accountsBank->bank_reconciliations()->create([
                'start_date'=>$start_date,
                'status'=>AccountsCoa::RECONCILIATION_NOT_TICKED,
                'notes'=>'Newly created bank transaction will be attached to this reconciliation, until it become closed(reconciled)'
            ]);
        }

    }

    public function transform_bank_account_types(AccountBankAccountType $accountBankAccountType){

        if(!$accountBankAccountType){
            return null;
        }
        return [
            'id'=>$accountBankAccountType->uuid,
            'name'=>$accountBankAccountType->name,
        ];

    }

    public function transform_bank_accounts(AccountsBank $accountsBank){

        $account_type = $accountsBank->account_types()->get()->first();
        $acc_type['id'] = $account_type->uuid;
        $acc_type['name'] = $account_type->name;
        $banker = $accountsBank->bank()->get()->first();
        $bank['id'] = $banker->uuid;
        $bank['name'] = $banker->name;
        $banker_branch = $accountsBank->bank_branch()->get()->first();
        $bank_branch['id'] = $banker_branch->uuid;
        $bank_branch['code'] = $banker_branch->code;
        $bank_branch['name'] = $banker_branch->name;
        return [
            'id'=>$accountsBank->uuid,
            'account_name'=>$accountsBank->account_name,
            'current_date'=>date("Y-m-d").'T12',
            'account_number'=>$accountsBank->account_number,
            'balance'=>$accountsBank->balance,
            'status'=>$accountsBank->status,
            'description'=>$accountsBank->description,
            'is_default'=>$accountsBank->is_default,
            'account_type'=>$acc_type,
            'bank'=>$bank,
            'bank_branch'=>$bank_branch,
        ];
    }

    public function transform_bank(AccountMasterBank $accountMasterBank){
        return [
            'id'=>$accountMasterBank->uuid,
            'name'=>$accountMasterBank->name,
            'description'=>$accountMasterBank->description,
            'phone'=>$accountMasterBank->phone,
            'address'=>$accountMasterBank->address,
            'email'=>$accountMasterBank->email,
            'code'=>$accountMasterBank->code,
            'comments'=>$accountMasterBank->comments,
        ];
    }

    public function transform_bank_branch( AccountMasterBankBranch $accountMasterBankBranch ){

        $bank = $accountMasterBankBranch->bank()->get()->first();
        return [
            'id' => $accountMasterBankBranch->uuid,
            'name' => $accountMasterBankBranch->name,
            'code' => $accountMasterBankBranch->code,
            'address' => $accountMasterBankBranch->address,
            'bank' => $this->transform_bank($bank),
        ];

    }

    public function transform_bank_transaction( BankTransaction $bankTransaction, Model $company ){

        //Get Support Document(Which has account Holder Number)
        // $supportDoc = $bankTransaction->double_entry_support_document()->get()->first();
        // $double_entry['support_document'] = $this->accountingRepository->transform_support_document($supportDoc);

        $selection['id'] = null;
        $selection['name'] = null;
        $selections = array();
        $customer = null;
        $amount = 0;
        $account_number = null;
        $double_entry = [];

        if( $bankTransaction->type == AccountsCoa::AC_TYPE_SUPPLIER ){

            //HERE THE SUPPORT DOCUMENT "transactionable" is Supplier
            $supportDoc = $bankTransaction->double_entry_support_document()->get()->first();
            // $double_entry['support_document'] = $this->accountingRepository->transform_support_document($supportDoc);
            //User Support Document to Find Account Holder
            $accountHolder = $supportDoc->account_holders()->get()->first();
            //Get Supplier,or Customer from AccountHolder
            $account_owner = $accountHolder->owner()->get()->first();
            $account_number = $accountHolder->account_number;
            $selection['id'] = $account_owner->uuid;
            $selection['name'] = $account_owner->display_as;

            $suppliers = $company->vendors()->get();
            foreach($suppliers as $suppl){
                $temp_suppl['id'] = $suppl->uuid;
                $temp_suppl['name'] = $suppl->display_as;
                array_push($selections,$temp_suppl);
            }
            $amount = $bankTransaction->spent;

        }else if( $bankTransaction->type == AccountsCoa::AC_TYPE_CUSTOMER ){

            //HERE THE SUPPORT DOCUMENT "transactionable" is Customer
            //User Support Document to Find Account Holder
            $supportDoc = $bankTransaction->double_entry_support_document()->get()->first();
            $accountHolder = $supportDoc->account_holders()->get()->first();
            //Get Supplier,or Customer from AccountHolder
            $account_owner = $accountHolder->owner()->get()->first();
            $account_number = $accountHolder->account_number;
            // $selection['id'] = $account_owner->uuid;
            // $selection['name'] = $account_owner->display_as;
            //
            $selection['id'] = $account_owner->uuid;
            $selection['name'] = $account_owner->legal_name;
            //$custome = $accountHolder->owner()->get()->first();
            $customer = $this->customerRepository->transform_customer($account_owner);
            $amount = $bankTransaction->received;

        }else if( $bankTransaction->type == AccountsCoa::AC_TYPE_ACCOUNT ){

            //HERE THE SUPPORT DOCUMENT "transactionable" is Chart of Accounts
            //Get Bank Account Transaction Occurred to
            $bankAccount = $bankTransaction->bank_accounts()->get()->first();
            //Then Get Bank Account Ledger Account
            $bankAccountLedger = $bankAccount->ledger_accounts()->get()->first();
            //This transaction occured on a Chart of Accounts
            $support_document = $bankAccountLedger->double_entry_support_document()->get()->first();
            //Get Double Entry
            $double_entry = $support_document->vouchers()->get()->first();
            $double_entry['support_document'] = $this->accountingRepository->transform_support_document($support_document);
            //$double_entry = $this->accountingRepository->transform_support_document();
            $selection['id'] = $bankAccountLedger->uuid;
            $selection['name'] = $bankAccountLedger->name;
            $amount = $double_entry->amount;

        }

        $vats['id'] = "id";
        $vats['name'] = "VAT";
        $vats['rate'] = 0;
        $vats['amount'] = 0;

        return [
            'id'=>$bankTransaction->uuid,
            'payee'=>$bankTransaction->payee,
            //'transaction_date'=>$bankTransaction->transaction_date,
            'transaction_date'=>date("Y-m-d", \strtotime($bankTransaction->created_at)),
            'description'=>$bankTransaction->description,
            'reference'=>$bankTransaction->reference,
            'discount'=>$bankTransaction->discount,
            'comment'=>$bankTransaction->comment,
            'type'=>$bankTransaction->type,
            'spent'=>$bankTransaction->spent,
            'received'=>$bankTransaction->received,
            'amount'=>$amount,
            'selection'=>$selection,
            'selections'=>$selections,
            'customer' => $customer,
            'double_entry' => $double_entry,
            'account_number'=>$account_number,
            'vat'=>$vats,
        ];

    }

    public function transform_bank_reconciliation( BankReconciliation $bankReconciliation, $show_reconciled_transaction = false, $filters=[] ){


        $bank_account = $bankReconciliation->bank_accounts()->get()->first();
        $reconciled_transactions = [];
        /*
            If user did not Tick a "Display Reconciled Transactions" checkbox, 
            then by default load Bank Transactions in this "BankReconciliation" only,
            else, Load Bank Transactions in this bank account based on the current Filters
        */
        //$transactions = $bankReconciliation->reconciled_transactions()->get();
        if($show_reconciled_transaction){
            $transactions = $bank_account->reconciled_transactions()
                ->whereRaw("created_at >= ? AND created_at <= ?",$filters)
                ->get();
        }else{
            $transactions = $bankReconciliation->reconciled_transactions()->get();
        }
        //Log::info($transactions);
        $company = $bank_account->owner()->get()->first();
        foreach( $transactions as $transaction ){ //This are reconciled transactions
            //Get Reconciled Transaction Status
            $statuses = $transaction->reconciled_transaction_states()->get();
            $trans_status = array();
            foreach ($statuses as $status) {
                $temp_status['id'] = $status->uuid;
                $temp_status['status'] = $status->status;
                $temp_status['notes'] = $status->notes;
                $temp_status['date'] = $this->helpers->format_mysql_date($status->created_at);
                $practice_user = $status->responsible()->get()->first();
                $temp_status['signatory'] = $this->companyUser->transform_user($practice_user);
                array_push($trans_status,$temp_status);
            }
            //Check the last status
            //If is Reconciled and user selected show Reconciled Transaction Load it
            if( (sizeof($trans_status)) && ($trans_status[sizeof($trans_status)-1]['status']==AccountsCoa::RECONCILIATION_RECONCILED) ){
                if($show_reconciled_transaction==true){
                    $bank_transaction = $transaction->bank_transactions()->get()->first();
                    $bank_trans = $this->transform_bank_transaction($bank_transaction,$company);
                    $bank_trans['reconciled_status'] = $trans_status;
                    array_push($reconciled_transactions,$bank_trans);
                }
            }else{
                $bank_transaction = $transaction->bank_transactions()->get()->first();
                $bank_trans = $this->transform_bank_transaction($bank_transaction,$company);
                $bank_trans['reconciled_status'] = $trans_status;
                array_push($reconciled_transactions,$bank_trans);
            }

            // $bank_transaction = $transaction->bank_transactions()->get()->first();
            // $bank_trans = $this->transform_bank_transaction($bank_transaction,$company);
            // $bank_trans['reconciled_status'] = $trans_status;
            // array_push($reconciled_transactions,$bank_trans);

        }

        return [
            'id'=>$bankReconciliation->uuid,
            'account_balance'=>$bankReconciliation->account_balance,
            'statement_balance'=>$bankReconciliation->statement_balance,
            'reconciled_amount'=>$bankReconciliation->reconciled_amount,
            'end_date'=>$bankReconciliation->end_date,
            'status'=>$bankReconciliation->status,
            'statement_date'=>$bankReconciliation->statement_date,
            'start_date'=>$bankReconciliation->start_date,
            'notes'=>$bankReconciliation->notes,
            'bank_account'=>$this->transform_bank_accounts($bank_account),
            'reconciled_transactions'=>$reconciled_transactions,
        ];

    }
    
}
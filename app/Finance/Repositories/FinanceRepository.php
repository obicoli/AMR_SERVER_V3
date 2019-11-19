<?php

namespace App\Finance\Repositories;

use App\Accounting\Models\COA\AccountsCoa;
use App\Finance\Models\Banks\AccountBankAccountType;
use Illuminate\Database\Eloquent\Model;
use App\Finance\Models\Banks\AccountMasterBank;
use App\Finance\Models\Banks\AccountMasterBankBranch;
use App\Finance\Models\Banks\AccountsBank;
use App\Finance\Models\Banks\BankReconciliation;
use App\Finance\Models\Banks\BankTransaction;
use App\helpers\HelperFunctions;

class FinanceRepository implements FinanceRepositoryInterface
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

    public function delete($id){
        return $this->model->find($id)->delete();
    }

    public function update(array $arr, $id){
        return $this->model->find($id)->update($arr);
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
        $supportDoc = $bankTransaction->double_entry_support_document()->get()->first();
        //User Support Document to Find Account Holder
        $accountHolder = $supportDoc->account_holders()->get()->first();
        //Get Supplier,or Customer from AccountHolder
        $account_owner = $accountHolder->owner()->get()->first();
        $selection['id'] = $account_owner->uuid;
        $selection['name'] = $account_owner->display_as;
        $selections = array();
        if( $bankTransaction->type == AccountsCoa::AC_TYPE_SUPPLIER ){
            $suppliers = $company->vendors()->get();
            foreach($suppliers as $suppl){
                $temp_suppl['id'] = $suppl->uuid;
                $temp_suppl['name'] = $suppl->display_as;
                array_push($selections,$temp_suppl);
            }
        }

        $vats['id'] = "id";
        $vats['name'] = "VAT";
        $vats['rate'] = 0;
        $vats['amount'] = 0;

        return [
            'id'=>$bankTransaction->uuid,
            'payee'=>$bankTransaction->payee,
            'transaction_date'=>$bankTransaction->transaction_date,
            'description'=>$bankTransaction->description,
            'reference'=>$bankTransaction->reference,
            'discount'=>$bankTransaction->discount,
            'comment'=>$bankTransaction->comment,
            'type'=>$bankTransaction->type,
            'spent'=>$bankTransaction->spent,
            'received'=>$bankTransaction->received,
            'selection'=>$selection,
            'selections'=>$selections,
            'vat'=>$vats,
        ];

    }

    public function transform_bank_reconciliation( BankReconciliation $bankReconciliation ){
        return [
            'id'=>$bankReconciliation->uuid,
        ];
    }
    
}
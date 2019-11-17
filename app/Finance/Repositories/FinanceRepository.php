<?php

namespace App\Finance\Repositories;

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

    public function transform_bank_transaction( BankTransaction $bankTransaction ){

        return [
            'id'=>$bankTransaction->uuid,
        ];

    }

    public function transform_bank_reconciliation( BankReconciliation $bankReconciliation ){
        return [
            'id'=>$bankReconciliation->uuid,
        ];
    }
    
}
<?php

namespace App\Finance\Repositories;

use App\Finance\Models\Banks\AccountBankAccountType;
use App\Finance\Models\Banks\AccountMasterBank;
use App\Finance\Models\Banks\AccountMasterBankBranch;
use App\Finance\Models\Banks\AccountsBank;
use App\Finance\Models\Banks\BankReconciliation;
use App\Finance\Models\Banks\BankTransaction;

interface FinanceRepositoryInterface 
{
    public function all();
    public function find($id);
    public function findByUuid($uuid);
    public function findByCode($code);
    public function create($inputs = []);
    public function delete($id);
    public function transform_bank_account_types(AccountBankAccountType $accountBankAccountType);
    public function transform_bank(AccountMasterBank $accountMasterBank);
    public function transform_bank_accounts(AccountsBank $accountsBank);
    public function transform_bank_branch( AccountMasterBankBranch $accountMasterBankBranch );
    public function transform_bank_transaction( BankTransaction $bankTransaction );
    public function transform_bank_reconciliation( BankReconciliation $bankReconciliation );

}
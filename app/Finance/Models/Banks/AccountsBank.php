<?php

namespace App\Finance\Models\Banks;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\Voucher\AccountsSupport;
use App\Models\Module\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;

class AccountsBank extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_FINANCE_DB_CONN;
    protected $table = "accounts_banks";
    protected $fillable = [
        'account_name',
        'account_number',
        'balance',
        'status',
        'account_type_id',
        'bank_id',
        'branch_id',
        'description',
        'unique_code' //This is a flag link any transaction that happens to this account
    ];

    public function owner(){ return $this->morphTo();}

    public function bank(){ return $this->belongsTo(AccountMasterBank::class,'bank_id');}

    public function bank_branch(){ return $this->belongsTo(AccountMasterBankBranch::class,'branch_id');}

    public function account_types(){ return $this->belongsTo(AccountBankAccountType::class,'account_type_id'); }

    //public function ledger_accounts(){ return $this->belongsTo(AccountsCoa::class,'ledger_account_id','id'); }

    public function ledger_accounts(){ return $this->belongsTo(AccountChartAccount::class,'ledger_account_id','id'); }

    public function bank_transactions(){ return $this->hasMany(BankTransaction::class,'bank_account_id','id'); }

    public function bank_reconciliations(){ return $this->hasMany(BankReconciliation::class,'bank_account_id','id'); }

    public function double_entry_support_document(){
        return $this->morphMany(AccountsSupport::class,'transactionable','transactionable_type','transactionable_id');
    }

    public function reconciled_transactions(){ return $this->hasMany(ReconciledTransaction::class,'bank_account_id','id'); }

}

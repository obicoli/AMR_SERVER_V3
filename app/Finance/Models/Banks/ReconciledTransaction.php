<?php

namespace App\Finance\Models\Banks;

use App\Models\Module\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;

class ReconciledTransaction extends Model
{
    use SoftDeletes,UuidTrait;
    protected $connection = Module::MYSQL_FINANCE_DB_CONN;
    protected $table = "reconciled_transactions";
    protected $fillable = [
        'notes',
        'bank_reconciliation_id',
        'bank_transaction_id',
        'bank_account_id',
    ];

    public function bank_transactions(){ return $this->belongsTo(BankTransaction::class,'bank_transaction_id','id'); }
    public function bank_reconciliations(){ return $this->belongsTo(BankReconciliation::class,'bank_reconciliation_id','id'); }
    public function reconciled_transaction_states(){ return $this->hasMany(ReconciledTransactionState::class,'reconciled_transaction_id','id'); }
    public function bank_accounts(){ return $this->belongsTo(AccountsBank::class,'bank_account_id','id'); }
}

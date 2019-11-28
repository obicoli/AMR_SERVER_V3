<?php

namespace App\Finance\Models\Banks;

use App\Models\Module\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;

class BankReconciliation extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_FINANCE_DB_CONN;
    protected $table = "bank_reconciliations";
    protected $fillable = [
        'account_balance',
        'statement_balance',
        'reconciled_amount',
        'difference',
        'reconciled_total',
        'reconciled_previous',
        'notes',
        'start_date',
        'end_date',
        'statement_date',
        'bank_account_id',
        'status',
    ];
    public function bank_accounts(){ return $this->belongsTo(AccountsBank::class,'bank_account_id','id'); }
    public function reconciled_transactions(){ return $this->hasMany(ReconciledTransaction::class,'bank_reconciliation_id','id'); }
}

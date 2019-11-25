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
        'statement_balance',
        'account_balance',
        'notes',
        'start_date',
        'end_date',
        'bank_account_id',
        'statement_date',
        'status',
        'reconciled_amount'
    ];
    public function bank_accounts(){ return $this->belongsTo(AccountsBank::class,'bank_account_id','id'); }
    public function reconciled_transactions(){ return $this->hasMany(ReconciledTransaction::class,'bank_reconciliation_id','id'); }
}

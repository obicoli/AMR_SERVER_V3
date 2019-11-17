<?php

namespace App\Finance\Models\Banks;

use App\Models\Module\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;

class ReconciledTransactionState extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_FINANCE_DB_CONN;
    protected $table = "bank_transactions";
    protected $fillable = [
        'status',
        'notes',
        'reconciled_transaction_id'
    ];

    public function responsible(){ return $this->morphTo();}
    public function reconciled_transactions(){ return $this->belongsTo(ReconciledTransaction::class,'reconciled_transaction_id','id'); }
}

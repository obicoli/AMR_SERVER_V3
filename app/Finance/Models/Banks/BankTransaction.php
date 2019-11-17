<?php

namespace App\Finance\Models\Banks;

use App\Models\Module\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;

class BankTransaction extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_FINANCE_DB_CONN;
    protected $table = "bank_transactions";
    protected $fillable = [
        'received',
        'spent',
        'transaction_date',
        'type',
        'reference',
        'description',
        'payee',
        'bank_account_id'
    ];
    public function bank_accounts(){ return $this->belongsTo(AccountsBank::class,'bank_account_id','id'); }
    public function reconciled_transactions(){ return $this->hasMany(ReconciledTransaction::class,'bank_transaction_id','id'); }
    public function bank_transaction_assets(){ return $this->hasMany(BankTransactionAsset::class,'bank_transaction_id','id'); }

}

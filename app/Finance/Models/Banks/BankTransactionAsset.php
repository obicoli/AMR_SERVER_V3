<?php

namespace App\Finance\Models\Banks;

use App\Models\Module\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;

class BankTransactionAsset extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_FINANCE_DB_CONN;
    protected $table = "bank_transaction_assets";
    protected $fillable = [
        'file_path',
        'file_mime',
        'file_name',
        'file_size',
        'bank_transaction_id',
    ];
    public function bank_transactions(){ return $this->belongsTo(BankTransaction::class,'bank_transaction_id','id'); }
}

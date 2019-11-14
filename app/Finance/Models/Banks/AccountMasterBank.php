<?php

namespace App\Finance\Models\Banks;

use App\Models\Module\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;

class AccountMasterBank extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_FINANCE_DB_CONN;
    protected $table = "account_master_banks";
    protected $fillable = [
        'name',
        'description',
        'phone',
        'address',
        'email',
        'code',
        'comments',
        'ledger_account_id'
    ];

    public function branches(){ return $this->hasMany(AccountMasterBankBranch::class,'bank_id','id'); }
    
}

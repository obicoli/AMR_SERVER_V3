<?php

namespace App\Accounting\Models\Banks;

use App\Models\Module\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;

class AccountMasterBankBranch extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_ACCOUNTING_DB_CONN;
    protected $table = "account_master_bank_branches";
    protected $fillable = [
        'name',
        'code',
        'bank_id'
    ];

    public function bank(){ return $this->belongsTo(AccountMasterBank::class,'bank_id'); }
}

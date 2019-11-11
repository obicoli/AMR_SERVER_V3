<?php

namespace App\Accounting\Models\COA;

use App\Accounting\Models\Voucher\AccountsSupport;
use App\Models\Module\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;

class AccountsHolder extends Model
{

    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_ACCOUNTING_DB_CONN;
    protected $table = "account_holders";
    protected $fillable = [
        'account_type',
        'name',
        'main',
        'bonus',
        'balance',
        'account_number'
    ];
    public function owner(){return $this->morphTo('owner','owner_type','owner_id');}
    public function supports(){ return $this->hasMany(AccountsSupport::class,'account_number','account_number'); }
    
}

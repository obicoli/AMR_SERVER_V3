<?php

namespace App\Accounting\Models\Tax;

use App\Accounting\Models\AccountHolder;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Module\Module;

class AccountsTaxReturnItem extends Model
{
    protected $connection = Module::MYSQL_ACCOUNTING_DB_CONN;
    protected $table = "accounts_tax_return_items";
    protected $fillable = [
        'tax_return_id',
    ];
    public function taxReturns(){ return $this->belongsTo(AccountsVatReturn::class,'tax_return_id','id'); }
}

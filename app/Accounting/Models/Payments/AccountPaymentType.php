<?php

namespace App\Accounting\Models\Payments;

use App\Customer\Models\Customer;
use App\Models\Module\Module;
use App\Models\Product\Supply\ProductSupply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;

class AccountPaymentType extends Model
{
    use SoftDeletes, UuidTrait,Accountable;
    protected $connection = Module::MYSQL_ACCOUNTING_DB_CONN;
    protected $table = "account_payment_types";
    protected $fillable = [
        'name',
        'description'
    ];
    public function owning(){ return $this->morphTo();}
    public function customers(){ return $this->hasMany(Customer::class,'prefered_payment_id'); }

}

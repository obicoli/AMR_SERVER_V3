<?php

namespace App\Customer\Models;

use App\Models\Account\Account;
use App\Models\Localization\Country;
use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerAddress extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_addresses";
    protected $account_type = Account::AC_CUSTOMERS;
    protected $fillable = [
        'type',
        'address',
        'region',
        'city',
        'postal_code',
        'country_id',
        'customer_id',
        'zip_code',
        'phone',
        'state',
        'fax'
    ];

    public function customers(){ return $this->belongsTo(Customer::class,'customer_id'); }
    public function countries(){ return $this->belongsTo(Country::class,'country_id'); }
}

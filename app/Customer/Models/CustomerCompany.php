<?php

namespace App\Customer\Models;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerCompany extends Model
{
    //
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_companies";
    protected $fillable = [
        'name',
        'email',
        'tax_registration',
        'address',
        'phone',
        'mobile',
        'logo',
        'notes'
    ];

    public function owner()
    {
        return $this->morphTo();
    }

    public function owning()
    {
        return $this->morphTo();
    }

    public function customers(){ return $this->hasMany(Customer::class,'company_id'); }
}

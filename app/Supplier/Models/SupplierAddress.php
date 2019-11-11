<?php

namespace App\Supplier\Models;

use App\Models\Account\Account;
use App\Models\Localization\Country;
use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierAddress extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_SUPPLIERS_DB_CONN;
    protected $table = "supplier_addresses";
    protected $account_type = Account::AC_SUPPLIERS;
    protected $fillable = [
        'type',
        'address',
        'region',
        'city',
        'postal_code',
        'country_id',
        'supplier_id',
        'zip_code',
        'phone',
        'state',
        'fax'
    ];

    public function suppliers(){ return $this->belongsTo(Supplier::class,'supplier_id'); }
    public function countries(){ return $this->belongsTo(Country::class,'country_id'); }
}

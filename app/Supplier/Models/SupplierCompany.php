<?php

namespace App\Supplier\Models;

use App\Models\Module\Module;
use App\Models\Product\ProductItem;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierCompany extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_SUPPLIERS_DB_CONN;
    protected $table = "supplier_companies";
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

    public function product_items(){ return $this->hasMany(ProductItem::class,'prefered_supplier_id'); }

    public function suppliers(){ return $this->hasMany(Supplier::class,'company_id'); }
}

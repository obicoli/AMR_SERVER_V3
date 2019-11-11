<?php

namespace App\Models\Product;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductManufacture extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;
    protected $table = "product_manufactures";
    protected $fillable = [
        'name'
    ];
    public function product_items(){ return $this->hasMany(ProductItem::class,'product_manufacturer_id'); }
}

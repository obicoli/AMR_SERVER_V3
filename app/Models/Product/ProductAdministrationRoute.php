<?php

namespace App\Models\Product;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAdministrationRoute extends Model
{
    use Accountable, UuidTrait, SoftDeletes;
    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;
    protected $table = "product_administration_routes";

    protected $fillable = [
        'name',
        'description',
    ];

    public function product_items(){ return $this->hasMany(ProductItem::class,'product_route_id'); }

    //public function product_type(){ return $this->belongsToMany(ProductType::class,'product_type_routes','product_type_id','product_administration_route_id'); }

}

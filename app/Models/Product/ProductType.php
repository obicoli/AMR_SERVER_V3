<?php

namespace App\Models\Product;

use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    //Drug, Supplies, Equipment
    use SoftDeletes, UuidTrait, Accountable;

    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;

    protected $table = 'product_types';

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function owner()
    {
        return $this->morphTo();
    }
    //public function product_routes(){ return $this->belongsToMany(ProductAdministrationRoute::class,'product_type_routes','product_type_id','product_administration_route_id'); }
    //public function product_category(){ return $this->belongsToMany(ProductCategory::class,'product_type_categories','product_type_id','product_category_id'); }

}

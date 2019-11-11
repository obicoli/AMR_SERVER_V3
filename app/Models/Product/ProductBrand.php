<?php

namespace App\Models\Product;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBrand extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;

    protected $table = 'product_brands';

    protected $fillable = [
        'name',
        'description',
        'company_id',
        'status',
        'owner_type',
        'owner_id'
    ];

    public function owner(){ return $this->morphTo();}
    //public function practices(){ return $this->belongsTo(ProductBrand::class, 'practice_product_brands','product_brand_id','practice_id'); }
}

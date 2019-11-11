<?php

namespace App\Models\Product;

use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Practice\PracticeProductItem;

class ProductCategory extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;

    protected $table = 'product_categories';

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function owner(){ return $this->morphTo();}

    public function product_items(){ return $this->hasMany(PracticeProductItem::class,'product_category_id'); }
    public function product_type(){ return $this->belongsToMany(ProductType::class,'product_type_categories','product_type_id','product_category_id'); }
    public function practice(){ return $this->belongsTo(Practice::class, 'practice_id'); }
}

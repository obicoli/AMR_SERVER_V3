<?php

namespace App\Models\Product;

use App\Models\Practice\Practice;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Practice\PracticeProductItem;

class ProductOrderCategory extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'product_order_categories';

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function owner(){ return $this->morphTo();}

    public function product_items(){ return $this->hasMany(PracticeProductItem::class,'product_order_category_id'); }
}

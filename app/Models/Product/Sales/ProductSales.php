<?php

namespace App\Models\Product\Sales;

use App\Models\Practice\Practice;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSales extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $table = "product_sales";
    protected $fillable = [
        'practice_id'
    ];

    public function practices(){ return $this->belongsTo(Practice::class, 'practice_id'); }
    public function product_sale_items(){ return $this->hasMany(ProductSaleItem::class,'product_sale_id'); }
}

<?php

namespace App\Models\Product\Inventory\Outward;

use App\Models\Practice\Department;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Practice\PracticeProductItem;
use App\Models\Product\Store\ProductStore;

class ProductStockOutward extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'product_stock_outwards';

    protected $fillable = [
        'amount',
        'batch_number',
        'product_item_id',
        'product_item_price_id',
        'outward_type',
    ];

    public function product_stocks(){ return $this->belongsTo(ProductStock::class,'product_stock_id'); }
}

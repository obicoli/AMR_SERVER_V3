<?php

namespace App\Models\Product\Inventory\Outward;

use App\Models\Practice\Department;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStockSale extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'product_stock_sales';

    protected $fillable = [
        'amount',
        //'batch_number',
        'product_item_id',
        'product_stock_id',
        //'product_price_id',
        //'status',
    ];
}

<?php

namespace App\Models\Product\Inventory\Outward;

use App\Models\Module\Module;
use App\Models\Product\Inventory\Inward\ProductStockInward;
// use App\Models\Practice\Department;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Models\Practice\PracticeProductItem;
// use App\Models\Product\Store\ProductStore;
// use App\Models\Product\Supply\ProductSupply;
use App\Models\Product\Supply\ProductSupplyItem;

class ProductStockSupply extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;

    protected $table = 'product_stock_out_supplies';

    protected $fillable = [
        'amount',
        'batch_number',
        'product_stock_inward_id',
        'product_supply_item_id'
    ];

    public function product_supply_items(){
        return $this->belongsTo(ProductSupplyItem::class,'product_supply_item_id');
    }

    public function product_stock_inwards(){
        return $this->belongsTo(ProductStockInward::class,'product_stock_inward_id');
    }
}

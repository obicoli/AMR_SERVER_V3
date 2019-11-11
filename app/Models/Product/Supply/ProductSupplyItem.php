<?php

namespace App\Models\Product\Supply;

use App\Models\Practice\PracticeProductItem;
use App\Models\Product\Inventory\Outward\ProductStockSupply;
use App\Models\Product\Sales\ProductPriceRecord;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSupplyItem extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $table = "product_supply_items";
    protected $fillable = [
        'description',
        'discount_allowed',
        'total_tax',
        'qty',
        'product_price_id',
        'product_item_id'
    ];
    
    public function prices(){ return $this->belongsTo(ProductPriceRecord::class,'product_price_id'); }
    public function product_items(){ return $this->belongsTo(PracticeProductItem::class,'product_item_id'); }
    public function product_supply(){ return $this->belongsTo(ProductSupply::class,'product_supply_id'); }
    public function product_stock_out_supplies(){ return $this->hasMany(ProductStockSupply::class,'product_supply_item_id'); }

}

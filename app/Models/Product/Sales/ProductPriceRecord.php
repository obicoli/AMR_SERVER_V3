<?php

namespace App\Models\Product\Sales;

use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeProductItem;
use App\Models\Product\Inventory\Inward\ProductStockInward;
use App\Models\Product\Inventory\ProductRequistionItem;
use App\Models\Product\Purchase\ProductPurchaseItem;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPriceRecord extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;
    protected $table = "product_price_records";
    protected $fillable = [
        'practice_id',
        'practice_product_item_id',
        'start_date',
        'unit_cost',
        'unit_retail_price',
        'pack_cost',
        'pack_retail_price',
        'status',
    ];

    //
    public function product_stock_inward(){ return $this->hasMany(ProductStockInward::class,'product_price_id'); }
    public function practice_product_items(){ return $this->belongsTo(PracticeProductItem::class,'practice_product_item_id'); }
    public function practice(){ return $this->belongsTo(Practice::class,'practice_id'); }
    public function purchase_items(){ return $this->hasMany(ProductPurchaseItem::class,'product_price_id'); }
    public function product_requisition_items(){ return $this->hasMany(ProductRequistionItem::class,'product_price_id'); }
}

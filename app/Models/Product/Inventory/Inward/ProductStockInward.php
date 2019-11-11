<?php

namespace App\Models\Product\Inventory\Inward;

use App\Models\Module\Module;
use App\Models\Practice\Department;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Practice\PracticeProductItem;
use App\Models\Product\Inventory\Outward\ProductStockSupply;
use App\Models\Product\Store\ProductStore;
use App\Models\Product\Inventory\ProductStock;
use App\Models\Product\Sales\ProductPriceRecord;

class ProductStockInward extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    const STOCK_SOURCES_PURCHASE = "Purchase";
    const STOCK_SOURCES_PURCHASE_ORDER = "Purchase Order";
    const STOCK_SOURCES_RETURNS = "Returns";
    const STOCK_SOURCES_REQUISITIONS = "Requisition";

    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;

    protected $table = 'product_stock_inwards';

    protected $fillable = [
        'amount',
        'batch_number',
        'barcode',
        'exp_date',
        'source_type',
        'consumed_amount',
        'product_item_id',
        'product_price_id',
    ];

    public function owner(){return $this->morphTo();}
    public function sourceable(){return $this->morphTo();} //
    public function owning(){return $this->morphTo();}

    public function product_stocks(){ return $this->belongsTo(ProductStock::class,'product_stock_id'); }
    public function product_stock_supply_out(){ return $this->hasMany(ProductStockSupply::class,'product_stock_inward_id'); }
    public function product_items(){ return $this->belongsTo(PracticeProductItem::class,'product_item_id'); }
    public function prices(){ return $this->belongsTo(ProductPriceRecord::class,'product_price_id'); }
    public function inward_returns(){ return $this->hasMany(ProductStockInwardReturn::class,'product_stock_inward_id'); }

}

<?php

namespace App\Supplier\Models;

use App\Models\Module\Module;
use App\Models\Product\ProductItem;
use App\Models\Product\ProductTaxation;
use App\Models\Product\Sales\ProductPriceRecord;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrderItem extends Model
{
    use SoftDeletes,UuidTrait;
    protected $connection = Module::MYSQL_SUPPLIERS_DB_CONN;
    protected $table = "purchase_order_items";
    protected $fillable = [
        'purchase_order_id',
        'qty',
        'status',
        'description',
        'product_price_id',
        'product_item_id',
    ];

    public function prices(){ return $this->belongsTo(ProductPriceRecord::class,'product_price_id'); }
    public function product_items(){ return $this->belongsTo(ProductItem::class,'product_item_id'); }
    public function purchase_orders(){ return $this->belongsTo(PurchaseOrder::class,'purchase_order_id'); }
    public function taxations(){ return $this->belongsToMany(ProductTaxation::class,'po_item_taxations','po_item_id','product_taxation_id'); }
    
}

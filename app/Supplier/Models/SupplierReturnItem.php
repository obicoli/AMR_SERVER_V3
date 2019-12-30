<?php

namespace App\Supplier\Models;

use App\Models\Module\Module;
use App\Models\NotificationCenter\Inventory\NotificationInventoryMailAttach;
use App\Models\Product\ProductItem;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product\Sales\ProductPriceRecord;

class SupplierReturnItem extends Model
{
    use SoftDeletes, UuidTrait;
    protected $connection = Module::MYSQL_SUPPLIERS_DB_CONN;
    protected $table = "supplier_return_items";
    protected $fillable = [
        'supplier_return_id',
        'qty',
        'discount_rate',
        'line_discount',
        'description',
        'product_price_id',
        'product_item_id',
    ];
    public function product_items(){ return $this->belongsTo(ProductItem::class,'product_item_id'); }
    public function prices(){ return $this->belongsTo(ProductPriceRecord::class,'product_price_id'); }
}

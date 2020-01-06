<?php

namespace App\Supplier\Models;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product\ProductItem;
use App\Models\Product\Sales\ProductPriceRecord;

class SupplierCreditItem extends Model
{
    use SoftDeletes, UuidTrait,Accountable;
    protected $connection = Module::MYSQL_SUPPLIERS_DB_CONN;
    protected $table = "supplier_credit_items";
    protected $fillable = [
        'supplier_credit_id',
        'qty',
        'line_discount',
        'description',
        'product_price_id',
        'product_item_id',
    ];
    public function supplier_credits(){ return $this->belongsTo(SupplierCredit::class,'supplier_credit_id'); }
    public function product_items(){ return $this->belongsTo(ProductItem::class,'product_item_id'); }
    public function prices(){ return $this->belongsTo(ProductPriceRecord::class,'product_price_id'); }

}

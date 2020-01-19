<?php

namespace App\Customer\Models\Sales;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product\ProductItem;
use App\Models\Product\ProductTaxation;
use App\Models\Product\Sales\ProductPriceRecord;

class CustomerSalesReceiptItem extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_sales_receipt_items";
    protected $fillable = [
        'sales_receipt_id',
        'product_item_id',
        'qty',
        'discount_allowed',
        'product_price_id'
    ];
    public function itemTaxed(){ return $this->hasMany(CustomerSalesReceiptItemTaxation::class,'sales_receipt_item_id','id'); }
    public function salesReceipts(){ return $this->belongsTo(CustomerSalesReceipt::class,'sales_receipt_id','id'); }
    public function prices(){ return $this->belongsTo(ProductPriceRecord::class,'product_price_id','id'); }
    public function product_items(){ return $this->belongsTo(ProductItem::class,'product_item_id','id'); }
    public function taxations(){ return $this->belongsToMany(ProductTaxation::class,'customer_sales_receipt_item_taxations','sales_receipt_item_id','product_taxation_id'); }
}

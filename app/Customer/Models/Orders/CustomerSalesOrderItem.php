<?php

namespace App\Customer\Models\Orders;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsHolder;
use App\Accounting\Models\Payments\AccountPaymentType;
use App\Accounting\Models\Voucher\AccountsSupport;
use App\Customer\Models\Invoice\CustomerRetainerInvoice;
use App\Customer\Models\Quote\Estimate;
use App\Finance\Models\Banks\BankTransaction;
use App\Models\Module\Module;
use App\Models\Product\ProductItem;
use App\Models\Product\ProductTaxation;
use App\Models\Product\Sales\ProductPriceRecord;
use App\Supplier\Models\PurchaseOrder;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerSalesOrderItem extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_sales_order_items";

    protected $fillable = [
        'product_item_id',
        'qty',
        'sales_order_id',
        'discount_allowed',
        'product_price_id'
    ];
    public function prices(){ return $this->belongsTo(ProductPriceRecord::class,'product_price_id','id'); }
    public function salesOrders(){ return $this->belongsTo(CustomerSalesOrder::class,'sales_order_id','id'); }
    public function product_items(){ return $this->belongsTo(ProductItem::class,'product_item_id','id'); }
    public function taxations(){ return $this->belongsToMany(ProductTaxation::class,'salesorder_item_taxations','sales_order_item_id','product_taxation_id'); }
}

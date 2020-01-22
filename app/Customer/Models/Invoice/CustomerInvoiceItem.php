<?php

namespace App\Customer\Models\Invoice;

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

class CustomerInvoiceItem extends Model
{
    //
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_invoice_items";

    protected $fillable = [
        'customer_invoice_id',
        'product_item_id',
        'qty',
        'discount_allowed',
        'product_price_id'
    ];
    public function itemTaxed(){ return $this->hasMany(CustomerInvoiceTaxation::class,'customer_invoice_item_id','id'); }
    public function prices(){ return $this->belongsTo(ProductPriceRecord::class,'product_price_id','id'); }
    public function customerInvoices(){ return $this->belongsTo(CustomerInvoice::class,'customer_invoice_id','id'); }
    public function product_items(){ return $this->belongsTo(ProductItem::class,'product_item_id','id'); }
    public function taxations(){ return $this->belongsToMany(ProductTaxation::class,'customer_invoice_item_taxations','customer_invoice_item_id','product_taxation_id'); }
}

<?php

namespace App\Customer\Models\Sales;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsHolder;
use App\Accounting\Models\Payments\AccountPaymentType;
use App\Accounting\Models\Voucher\AccountsSupport;
use App\Customer\Models\Invoice\CustomerInvoice;
use App\Customer\Models\Invoice\CustomerRetainerInvoice;
use App\Customer\Models\Quote\Estimate;
use App\Finance\Models\Banks\BankTransaction;
use App\Models\Module\Module;
use App\Supplier\Models\PurchaseOrder;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerSalesReceiptItemTaxation extends Model
{
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_sales_receipt_taxations";
    protected $fillable = [
        'sales_receipt_item_id',
        'product_taxation_id',
        'sales_rate',
        'purchase_rate',
        'collected_on_sales',
        'collected_on_purchase',
    ];
    public function sales_receipt_items(){ return $this->belongsTo(CustomerSalesReceiptItem::class,'sales_receipt_item_id','id'); }
}

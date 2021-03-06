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

class CustomerSalesReceiptStatus extends Model
{
    use SoftDeletes,UuidTrait;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_sales_receipt_statuses";
    protected $fillable = [
        'status',
        'notes',
        'type'
    ];
    public function responsible(){ return $this->morphTo();}
    public function salesReceipts(){ return $this->belongsTo(CustomerSalesReceipt::class,'sales_receipt_id','id'); }
}

<?php

namespace App\Customer\Models\Sales;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsHolder;
use App\Accounting\Models\Payments\AccountPaymentType;
use App\Accounting\Models\Voucher\AccountsSupport;
use App\Customer\Models\Customer;
use App\Customer\Models\CustomerTerms;
use App\Customer\Models\Invoice\CustomerInvoice;
use App\Customer\Models\Invoice\CustomerRetainerInvoice;
use App\Customer\Models\Quote\Estimate;
use App\Finance\Models\Banks\BankTransaction;
use App\Models\Module\Module;
use App\Models\NotificationCenter\Inventory\NotificationInventoryMailAttach;
use App\Supplier\Models\PurchaseOrder;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerSalesReceipt extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_sales_receipts";
    protected $fillable = [
        'trans_number',
        'reference_number',
        'trans_date',
        //'due_date',
        'shipping_charges',
        'adjustment_charges',
        'notes',
        'terms_condition',
        'customer_id',
        'net_total',
        'grand_total',
        'total_tax',
        'total_discount',
        'overal_discount',
        'overal_discount_rate',
        //'payment_term_id',
        //'sales_basis',
        //'extractable_from'
    ];
    public function customers(){ return $this->belongsTo(Customer::class,'customer_id','id'); }
    public function items(){ return $this->hasMany(CustomerSalesReceiptItem::class,'sales_receipt_id','id'); }
    public function double_entry_support_document(){
        return $this->morphMany(AccountsSupport::class,'transactionable','transactionable_type','transactionable_id');
    }
    public function owning(){ return $this->morphTo();} //Branch level
    public function receiptStatus(){ return $this->hasMany(CustomerSalesReceiptStatus::class,'sales_receipt_id','id');}
    public function mails_attachments(){ return $this->morphMany(NotificationInventoryMailAttach::class,'attachable','attachable_type','attachable_id'); }
    public function payment_terms(){ return $this->belongsTo(CustomerTerms::class,'payment_term_id','id'); }
}

<?php

namespace App\Customer\Models\Orders;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsHolder;
use App\Accounting\Models\Payments\AccountPaymentType;
use App\Accounting\Models\Voucher\AccountsSupport;
use App\Customer\Models\Customer;
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

class CustomerSalesOrder extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_sales_orders";

    protected $fillable = [
        'trans_number',
        'reference_number',
        'trans_date',
        'due_date',
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
        'estimate_id',
        'payment_term_id'
    ];

    public function items(){ return $this->hasMany(CustomerSalesOrderItem::class,'sales_order_id','id'); }
    public function owning(){ return $this->morphTo();} //Branch level
    //public function customer(){ return $this->morphTo();}
    public function customers(){ return $this->belongsTo(Customer::class,'customer_id','id'); }
    public function salesorderStatus(){ return $this->hasMany(CustomerSalesOrderStatus::class,'sales_order_id','id');}
    public function mails_attachments(){ return $this->morphMany(NotificationInventoryMailAttach::class,'attachable','attachable_type','attachable_id'); }
}

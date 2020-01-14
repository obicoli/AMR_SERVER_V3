<?php

namespace App\Customer\Models\Invoice;

use App\Accounting\Models\Voucher\AccountsSupport;
use App\Customer\Models\Customer;
use App\Models\Module\Module;
use App\Models\NotificationCenter\Inventory\NotificationInventoryMailAttach;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerInvoice extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_invoices";
    protected $fillable = [
        'extracted_from',
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
        'payment_term_id',
        'sales_basis'
    ];

    public function double_entry_support_document(){
        return $this->morphMany(AccountsSupport::class,'transactionable','transactionable_type','transactionable_id');
    }
    public function invoiceStatus(){ return $this->hasMany(CustomerInvoiceStatus::class,'customer_invoice_id','id');}
    public function items(){ return $this->hasMany(CustomerInvoiceItem::class,'customer_invoice_id','id'); }
    public function mails_attachments(){ return $this->morphMany(NotificationInventoryMailAttach::class,'attachable','attachable_type','attachable_id'); }
}

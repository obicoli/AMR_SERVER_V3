<?php

namespace App\Customer\Models\Invoice;

use App\Customer\Models\Customer;
use App\Customer\Models\CustomerPayment;
use App\Models\Module\Module;
use App\Models\NotificationCenter\Inventory\NotificationInventoryMailAttach;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerRetainerInvoice extends Model
{
    use SoftDeletes, UuidTrait,Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_retainer_invoices";
    protected $fillable = [
        'trans_number',
        'customer_id',
        'reference_number',
        'trans_date',
        'description',
        'terms_condition',
        'notes',
        'estimate_id',
        'net_total',
        'total_tax',
        'grand_total'
    ];

    public function customerPayments(){
        return $this->belongsToMany(CustomerPayment::class,'customer_retainer_payments','customer_retainer_id','customer_payment_id');
    }
    public function paymentItems(){ return $this->hasMany(RetainerPaymentItems::class,'customer_retainer_id','id'); }
    public function owning(){ return $this->morphTo();} //Branch level
    public function items(){ return $this->hasMany(CustomerRetainerInvoiceItem::class,'retainer_invoice_id','id'); }
    public function customers(){ return $this->belongsTo(Customer::class,'customer_id','id'); }
    public function invoiceStatus(){ return $this->hasMany(CustomerRetainerInvoiceStatus::class,'retainer_invoice_id','id'); }
    public function mails_attachments(){ return $this->morphMany(NotificationInventoryMailAttach::class,'attachable','attachable_type','attachable_id'); }
}

<?php

namespace App\Customer\Models\Quote;

use App\Customer\Models\Customer;
use App\Customer\Models\Invoice\CustomerInvoice;
use App\Customer\Models\Orders\CustomerSalesOrder;
use App\Models\Module\Module;
use App\Models\NotificationCenter\Inventory\NotificationInventoryMailAttach;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estimate extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    const ACCEPTED = "Accepted";
    const DECLINED = "Declined";
    const DRAFT = "Draft";
    const SENT = "Sent";
    const VIEWD = "Viewed";
    const INVOICED = "Invoiced";
    const EXPIRED = "Expired";
    protected $table = "estimates";
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
        'taxation_option',
        'payment_term_id',
        'overal_discount_rate',
        'overal_discount'
    ];

    //public function salesOrders(){ return $this->hasMany(); }
    public function invoices(){return $this->morphMany(CustomerInvoice::class,'extractable','extractable_type','extractable_id');}
    public function items(){ return $this->hasMany(EstimateItems::class,'estimate_id'); }
    public function owning(){ return $this->morphTo();} //Branch level
    //public function customer(){ return $this->morphTo();}
    public function salesOrders(){ return $this->hasMany(CustomerSalesOrder::class,'estimate_id','id'); }
    public function customers(){ return $this->belongsTo(Customer::class,'customer_id','id'); }
    public function estimate_status(){ return $this->hasMany(EstimateStatus::class,'estimate_id');}
    public function mails_attachments(){ return $this->morphMany(NotificationInventoryMailAttach::class,'attachable','attachable_type','attachable_id'); }
}

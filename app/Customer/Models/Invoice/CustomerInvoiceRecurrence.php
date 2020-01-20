<?php

namespace App\Customer\Models\Invoice;

use App\Accounting\Models\Voucher\AccountsSupport;
use App\Customer\Models\Customer;
use App\Customer\Models\CustomerPayment;
use App\Customer\Models\CustomerPaymentItem;
use App\Customer\Models\CustomerTerms;
use App\Models\Module\Module;
use App\Models\NotificationCenter\Inventory\NotificationInventoryMailAttach;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerInvoiceRecurrence extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_invoice_recurrences";
    protected $fillable = [
        'cc_copy',
        'customer_invoice_id',
        'start_date',
        'end_date',
        'email',
        'cc_email',
        'frequency',
        'profile_name'
    ];

    public function customerInvoices(){ return $this->belongsTo(CustomerInvoice::class,'customer_invoice_id','id'); }
}

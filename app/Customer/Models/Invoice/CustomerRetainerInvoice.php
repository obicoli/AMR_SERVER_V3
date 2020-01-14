<?php

namespace App\Customer\Models\Invoice;

use App\Customer\Models\Customer;
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
    ];

    public function items(){ return $this->hasMany(CustomerRetainerInvoiceItem::class,'retainer_invoice_id','id'); }
    public function customers(){ return $this->belongsTo(Customer::class,'customer_id','id'); }
}

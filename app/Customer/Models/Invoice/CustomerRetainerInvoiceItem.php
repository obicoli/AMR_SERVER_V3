<?php

namespace App\Customer\Models\Invoice;

use App\Customer\Models\Customer;
use App\Models\Module\Module;
use App\Models\NotificationCenter\Inventory\NotificationInventoryMailAttach;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerRetainerInvoiceItem extends Model
{
    use SoftDeletes, UuidTrait,Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_retainer_invoice_items";
    protected $fillable = [
        'retainer_invoice_id',
        'description',
        'amount',
    ];
    public function retainer_invoices(){ return $this->belongsTo(CustomerRetainerInvoice::class,'retainer_invoice_id','id'); }
    
}

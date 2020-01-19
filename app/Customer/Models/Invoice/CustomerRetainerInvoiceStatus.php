<?php

namespace App\Customer\Models\Invoice;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerRetainerInvoiceStatus extends Model
{
    use SoftDeletes, UuidTrait;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_retainer_statuses";
    protected $fillable = [
        'retainer_invoice_id',
        'status',
        'notes',
        'type'
    ];
    public function responsible(){ return $this->morphTo();}
    public function retainer_invoices(){ return $this->belongsTo(CustomerRetainerInvoice::class,'retainer_invoice_id','id'); }
}

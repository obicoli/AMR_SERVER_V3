<?php

namespace App\Customer\Models\Invoice;

use App\Customer\Models\Customer;
use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerInvoiceStatus extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_invoice_statuses";
    protected $fillable = [
        'status',
        'notes',
        'type'
    ];
    public function responsible(){ return $this->morphTo();}
    public function invoces(){ return $this->belongsTo(CustomerInvoice::class,'customer_invoice_id','id'); }
}

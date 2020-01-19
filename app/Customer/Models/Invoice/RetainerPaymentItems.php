<?php

namespace App\Customer\Models\Invoice;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class RetainerPaymentItems extends Model
{
    use UuidTrait;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_retainer_payments";
    protected $fillable = [
        'customer_retainer_id',
        'customer_payment_id',
        'paid_amount',
    ];

    public function retainerInvoice(){ return $this->belongsTo(CustomerRetainerInvoice::class,'customer_retainer_id','id'); }
}

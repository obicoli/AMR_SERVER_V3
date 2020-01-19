<?php

namespace App\Customer\Models;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerPaymentItem extends Model
{
    use UuidTrait;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_invoice_payments";
    protected $fillable = [
        'customer_invoice_id',
        'customer_payment_id',
        'paid_amount',
    ];
}

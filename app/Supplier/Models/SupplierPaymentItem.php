<?php

namespace App\Supplier\Models;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierPaymentItem extends Model
{
    use SoftDeletes, UuidTrait;
    protected $connection = Module::MYSQL_SUPPLIERS_DB_CONN;
    protected $table = "supplier_bill_payment";
    protected $fillable = [
        'supplier_bill_id',
        'supplier_payment_id',
        'paid_amount',
    ];
    // public function supplier_payments(){ return $this->belongsTo(SupplierPayment::class,'supplier_payment_id','id'); }
    // public function supplierBills(){ return $this->belongsTo(SupplierBill::class,'bill_id','id'); }
}

<?php

namespace App\Supplier\Models;

use App\Finance\Models\Banks\BankTransaction;
use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierPayment extends Model
{
    use SoftDeletes, UuidTrait,Accountable;
    protected $connection = Module::MYSQL_SUPPLIERS_DB_CONN;
    protected $table = "supplier_payments"; 
    protected $fillable = [
        'supplier_id',
        'bill_id',
        'ledger_account_id',
        'payment_date',
        'payment_method',
        'amount',
        'status',
        'settlement_type',
        'notes',
        'reference_number',
        'trans_number',
    ];

    public function payment_status(){ return $this->hasMany(SupplierPaymentStatus::class,'supplier_payment_id','id');}
    public function suppliers(){ return $this->belongsTo(Supplier::class,'supplier_id','id'); }
    public function supplierBills(){ return $this->belongsTo(SupplierBill::class,'bill_id','id'); }
    public function bank_transactions(){ return $this->morphMany(BankTransaction::class,'transactionable','transactionable_type','transactionable_id'); }
}

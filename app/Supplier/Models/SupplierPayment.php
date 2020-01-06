<?php

namespace App\Supplier\Models;

use App\Accounting\Models\Voucher\AccountsSupport;
use App\Finance\Models\Banks\BankTransaction;
use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\NotificationCenter\Inventory\NotificationInventoryMailAttach;

class SupplierPayment extends Model
{
    use SoftDeletes, UuidTrait,Accountable;
    protected $connection = Module::MYSQL_SUPPLIERS_DB_CONN;
    protected $table = "supplier_payments"; 
    protected $fillable = [
        'supplier_id',
        'bill_id',
        'ledger_account_id',
        'trans_date',
        'payment_method',
        'amount',
        'status',
        'settlement_type',
        'notes',
        'reference_number',
        'trans_number',
    ];

    public function assets(){
        return $this->morphMany(SupplierAsset::class, 'owner');
    }
    public function double_entry_support_document(){
        return $this->morphMany(AccountsSupport::class,'transactionable','transactionable_type','transactionable_id');
    }
    public function payment_status(){ return $this->hasMany(SupplierPaymentStatus::class,'supplier_payment_id','id');}
    public function suppliers(){ return $this->belongsTo(Supplier::class,'supplier_id','id'); }
    //public function supplierBills(){ return $this->belongsTo(SupplierBill::class,'bill_id','id'); }
    public function supplierBills(){ return $this->belongsToMany(SupplierBill::class,'supplier_bill_payment','supplier_payment_id','supplier_bill_id'); }
    public function bank_transactions(){ return $this->morphMany(BankTransaction::class,'transactionable','transactionable_type','transactionable_id'); }
    public function items(){ return $this->hasMany(SupplierPaymentItem::class,'supplier_payment_id','id'); }
    public function mails_attachments(){ return $this->morphMany(NotificationInventoryMailAttach::class,'attachable','attachable_type','attachable_id'); }
}

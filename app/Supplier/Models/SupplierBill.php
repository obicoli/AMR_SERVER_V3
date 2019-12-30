<?php

namespace App\Supplier\Models;

use App\Models\Account\Account;
use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Accounting\Models\COA\AccountsHolder;
use App\Accounting\Models\Voucher\AccountsSupport;
use App\Models\Localization\Country;
use App\Models\NotificationCenter\Inventory\NotificationInventoryMailAttach;

class SupplierBill extends Model
{
    use SoftDeletes, UuidTrait,Accountable;
    protected $connection = Module::MYSQL_SUPPLIERS_DB_CONN;
    protected $table = "supplier_bills"; 
    protected $fillable = [
        'order_number',
        'trans_number',
        'bill_date',
        'bill_due_date',
        'supplier_id',
        'taxation_option',
        'notes',
        'ledger_account_id',
        'payment_term_id',
        'bill_type',
        'net_total',
        'grand_total',
        'total_tax',
        'total_discount',
        'supplier_invoice_number',
        'delivery_form_number',
    ];
    public function assets(){
        return $this->morphMany(SupplierAsset::class, 'owner');
    }
    public function suppliers(){ return $this->belongsTo(Supplier::class,'supplier_id','id'); }
    public function billable(){ return $this->morphTo(); } //This is Polymorphy
    public function items(){ return $this->hasMany(SupplierBillItem::class,'supplier_bill_id'); }
    public function bill_status(){ return $this->hasMany(SupplierBillStatus::class,'supplier_bill_id');}
    public function payments(){ return $this->belongsToMany(SupplierPayment::class,'supplier_bill_payment','supplier_bill_id','supplier_payment_id'); }
    //public function payments(){ return $this->hasMany(SupplierPayment::class,'bill_id','id'); }
    public function paymentItems(){ return $this->hasMany(SupplierPaymentItem::class,'supplier_bill_id','id'); } //supplier_bill_id
    public function double_entry_support_document(){
        return $this->morphMany(AccountsSupport::class,'transactionable','transactionable_type','transactionable_id');
    }
    public function supplierReturns(){ return $this->belongsToMany(SupplierReturn::class,'supplier_bills_returns','supplier_return_id','supplier_bill_id'); }
    public function mails_attachments(){ return $this->morphMany(NotificationInventoryMailAttach::class,'attachable','attachable_type','attachable_id'); }
    
}

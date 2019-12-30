<?php

namespace App\Supplier\Models;

use App\Accounting\Models\Voucher\AccountsSupport;
use App\Models\Module\Module;
use App\Models\NotificationCenter\Inventory\NotificationInventoryMailAttach;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierReturn extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_SUPPLIERS_DB_CONN;
    protected $table = "supplier_returns";
    protected $fillable = [
        'supplier_id',
        'trans_number',
        'notes',
        'return_date',
        'taxation_option',
        'net_total',
        'grand_total',
        'total_tax',
        'total_discount'
    ];

    public function assets(){
        return $this->morphMany(SupplierAsset::class, 'owner');
    }

    public function double_entry_support_document(){
        return $this->morphMany(AccountsSupport::class,'transactionable','transactionable_type','transactionable_id');
    }
    public function suppliers(){ return $this->belongsTo(Supplier::class,'supplier_id','id'); }
    public function items(){ return $this->hasMany(SupplierReturnItem::class,'supplier_return_id','id'); }
    public function trails(){ return $this->hasMany(SupplierReturnStatus::class,'supplier_return_id','id');}
    public function supplierBills(){ return $this->belongsToMany(SupplierBill::class,'supplier_bills_returns','supplier_bill_id','supplier_return_id'); }
    public function mails_attachments(){ return $this->morphMany(NotificationInventoryMailAttach::class,'attachable','attachable_type','attachable_id'); }
}

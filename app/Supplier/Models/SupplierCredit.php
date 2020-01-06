<?php

namespace App\Supplier\Models;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Accounting\Models\Voucher\AccountsSupport;
use App\Models\NotificationCenter\Inventory\NotificationInventoryMailAttach;

class SupplierCredit extends Model
{
    use SoftDeletes, UuidTrait,Accountable;
    protected $connection = Module::MYSQL_SUPPLIERS_DB_CONN;
    protected $table = "supplier_credits";
    protected $fillable = [
        'trans_number',
        'taxation_option',
        'trans_date',
        'supplier_id',
        'taxation_option',
        'notes',
        'bill_type',
        'net_total',
        'grand_total',
        'total_tax',
        'total_discount',
    ];
    public function assets(){ return $this->morphMany(SupplierAsset::class, 'owner'); }
    public function suppliers(){ return $this->belongsTo(Supplier::class,'supplier_id','id'); }
    public function billable(){ return $this->morphTo(); } //This is Polymorphy
    public function items(){ return $this->hasMany(SupplierCreditItem::class,'supplier_credit_id','id'); }
    public function trails(){ return $this->hasMany(SupplierCreditStatus::class,'supplier_credit_id','id');}
    public function double_entry_support_document(){ return $this->morphMany(AccountsSupport::class,'transactionable','transactionable_type','transactionable_id');}
    public function mails_attachments(){ return $this->morphMany(NotificationInventoryMailAttach::class,'attachable','attachable_type','attachable_id'); }
}

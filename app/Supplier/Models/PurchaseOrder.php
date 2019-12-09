<?php

namespace App\Supplier\Models;

use App\Models\Module\Module;
use App\Models\NotificationCenter\Inventory\NotificationInventoryMailAttach;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_SUPPLIERS_DB_CONN;
    protected $table = "purchase_orders";
    protected $fillable = [
        'supplier_id',
        'terms',
        'trans_number',
        'notes',
        'po_date',
        'po_due_date',
        'ship_to',
        'taxation_option',
        'status',
    ];

    public function assets(){
        return $this->morphMany(SupplierAsset::class, 'owner');
    }
    public function owning(){ return $this->morphTo();} //Branch owning this PO
    public function shipable(){ return $this->morphTo();} //Can be a customer or a Facility
    public function po_status(){ return $this->hasMany(PurchaseOrderStatus::class,'purchase_order_id');}
    public function items(){ return $this->hasMany(PurchaseOrderItem::class,'purchase_order_id'); }
    public function mails_attachments(){ return $this->morphMany(NotificationInventoryMailAttach::class,'attachable','attachable_type','attachable_id'); }
    public function suppliers(){  return $this->belongsTo(Supplier::class,'supplier_id'); }
    public function bills(){  return $this->morphMany(SupplierBill::class,'billable','billable_type','billable_id'); }

}

<?php

namespace App\Models\Product\Inventory;

use App\Models\Practice\Department;
use App\Models\Product\Store\ProductStore;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRequistion extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'product_requistions';

    protected $fillable = [
        'note',
        'status'
    ];

    public function owner(){ return $this->morphTo();}
    public function src_owning(){ return $this->morphTo();}
    public function dest_owning(){ return $this->morphTo();} //practice
    public function requested(){ return $this->morphTo();} //Requested By

    public function source_departments(){ return $this->belongsTo(Department::class,'src_department_id'); }
    public function source_stores(){ return $this->belongsTo(ProductStore::class,'src_store_id'); }
    public function source_sub_stores(){ return $this->belongsTo(ProductStore::class,'src_sub_store_id'); }

    public function destination_departments(){ return $this->belongsTo(Department::class,'dest_department_id'); }
    public function destination_stores(){ return $this->belongsTo(ProductStore::class,'dest_store_id'); }
    public function destination_sub_stores(){ return $this->belongsTo(ProductStore::class,'dest_sub_store_id'); }

    public function product_requisition_items(){ return $this->hasMany(ProductRequistionItem::class,'product_requistion_id'); }
    //public function product_requisition_shippment(){ return $this->hasMany(ProductRequisitionShipment::class,'product_requistion_id'); } //stores shippment data
    public function product_requisition_states(){ return $this->hasMany(ProductRequisitionMovement::class,'product_requistion_id'); } //handles change in status

}

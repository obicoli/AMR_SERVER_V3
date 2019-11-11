<?php

namespace App\Models\Product\Supply;

use App\Assets\Models\Machines\Vehicle\Vehicle;
use App\Hrs\Models\Employee\HrsEmployee;
use App\Models\Account\Payments\AccountPaymentType;
use App\Models\Practice\Department;
use App\Models\Product\Store\ProductStore;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSupply extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $table = "product_supplies";
    protected $fillable = [
        'trans_number',
        'note',
        'status',
    ];

    public function owner(){ return $this->morphTo();}
    public function src_owning(){ return $this->morphTo();}
    public function dest_owning(){ return $this->morphTo();} //practice
    public function requested(){ return $this->morphTo();} //Requested By

    //Status
    public function product_supply_states(){ return $this->hasMany(ProductSupplyState::class,'product_supply_id'); }
    //Signatories
    //public function signatories(){ return $this->hasMany(ProductSupplySignatory::class,'product_supply_id'); }
    //
    public function payment_types(){ return $this->belongsTo(AccountPaymentType::class,'payment_type_id'); }
    //
    public function source_departments(){ return $this->belongsTo(Department::class,'src_department_id'); }
    public function source_stores(){ return $this->belongsTo(ProductStore::class,'src_store_id'); }
    public function source_sub_stores(){ return $this->belongsTo(ProductStore::class,'src_sub_store_id'); }

    public function destination_departments(){ return $this->belongsTo(Department::class,'dest_department_id'); }
    public function destination_stores(){ return $this->belongsTo(ProductStore::class,'dest_store_id'); }
    public function destination_sub_stores(){ return $this->belongsTo(ProductStore::class,'dest_sub_store_id'); }

    //Product supply
    public function goods_out_notes(){ return $this->morphMany(GoodsOutNote::class,'transactionable','transactionable_type','transactionable_id'); }
    public function product_supply_items(){ return $this->hasMany(ProductSupplyItem::class,'product_supply_id'); }

    public function vehicles(){ return $this->belongsTo(Vehicle::class,'vehicle_id'); }
    public function employees(){ return $this->belongsTo(HrsEmployee::class,'driver_id'); }

}

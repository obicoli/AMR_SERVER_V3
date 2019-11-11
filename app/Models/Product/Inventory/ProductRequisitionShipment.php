<?php

namespace App\Models\Product\Inventory;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRequisitionShipment extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'product_requisition_shipments';

    protected $fillable = [
        'trans_date'
    ];

    public function approving(){ return $this->morphTo();}
    public function shipping(){ return $this->morphTo();}
    public function receiving(){ return $this->morphTo();}

    public function product_requisitions(){ return $this->belongsTo(ProductRequistion::class,'product_requistion_id'); }
}

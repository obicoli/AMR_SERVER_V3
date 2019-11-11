<?php

namespace App\Models\Product\Inventory;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRequisitionMovement extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;

    protected $table = 'product_requisition_movements';

    protected $fillable = [
        'note',
        'status',
        'product_requistion_id'
    ];

    public function responsible(){ return $this->morphTo();}

    public function product_requisitions(){ return $this->belongsTo(ProductRequistion::class,'product_requistion_id','id'); }

}

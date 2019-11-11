<?php

namespace App\Supplier\Models;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrderStatus extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_SUPPLIERS_DB_CONN;
    protected $table = "purchase_order_statuses";
    protected $fillable = [
        'status',
        'notes'
    ];
    public function responsible(){ return $this->morphTo();}
    public function purchase_orders(){ return $this->belongsTo(PurchaseOrder::class,'purchase_order_id'); }
}

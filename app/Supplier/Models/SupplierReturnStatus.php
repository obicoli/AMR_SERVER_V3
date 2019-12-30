<?php

namespace App\Supplier\Models;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierReturnStatus extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_SUPPLIERS_DB_CONN;
    protected $table = "supplier_return_statuses";
    protected $fillable = [
        'status',
        'notes',
        'type',
    ];

    public function responsible(){ return $this->morphTo();}
    public function supplierReturns(){return $this->belongsTo(SupplierReturn::class,'supplier_return_id','id');}
}

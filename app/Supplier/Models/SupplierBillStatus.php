<?php

namespace App\Supplier\Models;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierBillStatus extends Model
{
    use SoftDeletes, UuidTrait,Accountable;
    protected $connection = Module::MYSQL_SUPPLIERS_DB_CONN;
    protected $table = "supplier_bill_statuses";
    protected $fillable = [
        'status',
        'notes',
        'type'
    ];
    public function responsible(){ return $this->morphTo();}
    public function supplier_bills(){ return $this->belongsTo(SupplierBill::class,'supplier_bill_id'); }
    
}

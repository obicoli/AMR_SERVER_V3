<?php

namespace App\Models\Product\Inventory;

use App\Models\Module\Module;
use App\Models\Practice\Department;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStockTaking extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;

    protected $table = "product_stock_takings";

    protected $fillable = [
        'barcode',
        'qty',
    ];

    public function owner(){ return $this->morphTo();}
    public function owning(){ return $this->morphTo();}
    public function departments(){ return $this->belongsTo(Department::class,'department_id'); }

}

<?php

namespace App\Assets\Models\Machines\Vehicle;

use App\Models\Module\Module;
use App\Models\Product\Supply\ProductSupply;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes,UuidTrait,Accountable;

    protected $connection = Module::MYSQL_ASSETS_DB_CONN;

    protected $table = "vehicles";

    protected $fillable = [
        'vhc_name',
        'vhc_number',
        'vhc_id',
        'vhc_chase_number',
        'vhc_engine_number',
        'vhc_date'
    ];

    public function owner(){ return $this->morphTo();} //Enterprise owning this Emp
    public function owning(){ return $this->morphTo();} //Branch owning this Emp
    public function product_supply(){ return $this->hasMany(ProductSupply::class,'vehicle_id'); }
    
}

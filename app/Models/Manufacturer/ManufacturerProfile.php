<?php

namespace App\Models\Manufacturer;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManufacturerProfile extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = "manufacturer_profiles";

    public function manufacturer(){ return $this->belongsTo(Manufacturer::class,'manufacturer_id'); }
}

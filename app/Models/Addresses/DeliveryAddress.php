<?php

namespace App\Models\Addresses;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryAddress extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'delivery_addresses';

    protected $fillable = [
        'region',
        'area',
        'street',
        'phone',
        'estate_landmark_buildings',
    ];

    public function owner()
    {
        return $this->morphTo();
    }

}

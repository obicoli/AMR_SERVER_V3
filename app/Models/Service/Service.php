<?php

namespace App\Models\Service;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    //These are system services: EMR, Calendar, Inventory, Treatment Notification
    use SoftDeletes, Accountable, UuidTrait;

    protected $table = "services";

    protected $guarded = [
        'name',
        'slug',
        'description',
    ];

    public function service_charge()
    {
        return $this->morphMany(ServiceCharge::class, 'owner','owner_type','owner_id');
    }
}

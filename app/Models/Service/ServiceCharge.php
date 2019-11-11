<?php

namespace App\Models\Service;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCharge extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = "service_charges";

    protected $fillable = [
        'service_type',
        'cost',
        'slug',
    ];

    public function owner()
    {
        return $this->morphTo();
    }
}

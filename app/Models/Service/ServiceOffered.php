<?php

namespace App\Models\Service;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceOffered extends Model
{
    //these are service offered in a practice eg Consultation, Laboratory etc
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = "service_offereds";

    protected $fillable = [
        'name',
        'description',
    ];
}

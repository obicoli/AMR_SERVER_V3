<?php

namespace App\Models\Localization;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'cities';

    protected $fillable = [
        'name',
        'county_id',
    ];

}

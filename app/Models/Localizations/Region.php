<?php

namespace App\Models\Localization;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'regions';

    protected $fillable = [
        'name',
        'country_id'
    ];
}

<?php

namespace App\Models\Localization;

use Illuminate\Database\Eloquent\Model;

class TimeZones extends Model
{
    protected $table = 'time_zones';

    protected $fillable = [
        'name',
        'label_name',
    ];
}

<?php

namespace App\Models\Emr\Treat;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proceedure extends Model
{
    use SoftDeletes,UuidTrait,Accountable;

    protected $table = 'proceedures';

    protected $fillable = [
        'name',
        'cost_per_unit',
        'discount',
        'units',
        'notes',
        'consultation_id',
    ];

}

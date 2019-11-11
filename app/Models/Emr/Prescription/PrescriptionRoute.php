<?php

namespace App\Models\Emr\Prescription;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrescriptionRoute extends Model
{
    use SoftDeletes, Accountable, UuidTrait;

    protected $table = 'prescription_routes';

    protected $fillable = [
        'name'
    ];
}

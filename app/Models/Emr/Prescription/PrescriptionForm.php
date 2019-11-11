<?php

namespace App\Models\Emr\Prescription;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrescriptionForm extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'prescription_forms';

    protected $fillable = [
        'name',
    ];

}

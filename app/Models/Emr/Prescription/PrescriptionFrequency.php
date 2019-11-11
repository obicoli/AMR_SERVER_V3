<?php

namespace App\Models\Emr\Prescription;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrescriptionFrequency extends Model
{
    use Accountable, UuidTrait, SoftDeletes;

    protected $table = 'prescription_frequencies';

    protected $fillable = [
        'name'
    ];
}

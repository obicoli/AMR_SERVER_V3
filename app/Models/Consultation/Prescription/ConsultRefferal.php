<?php

namespace App\Models\Consultation\Prescription;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultRefferal extends Model
{
    use UuidTrait, SoftDeletes, Accountable;

    protected $table = 'consult_refferals';

    protected $fillable = [
        'consultation_id',
        'is_urgent',
        'reason',
        'referal_type',
        'differential_diagnosis',
        'patient_expectation',
    ];

}

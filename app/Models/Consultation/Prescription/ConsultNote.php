<?php

namespace App\Models\Consultation\Prescription;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultNote extends Model
{
    use UuidTrait, SoftDeletes, Accountable;

    protected $table = 'consult_notes';

    protected $fillable = [
        'consultation_id',
        'classification_id',
        'doctor_action_id', //action doctor recommended
        'internal_notes', //notice from consultation to be used internally(company) patient not to see
        'patient_notes', //notice from consultation to be used by patient
    ];

}

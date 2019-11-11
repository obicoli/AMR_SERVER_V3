<?php

namespace App\Models\Consultation\Prescription;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultPrescription extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'consult_prescriptions';

    protected $fillable = [
        'name',
        'dosage',
        'administration_duration',
        'frequency_id',
        'route_id',
        'consultation_id',
        'form_id',
        'patient_direction',
    ];

}

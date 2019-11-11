<?php

namespace App\Models\Consultation;

use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientSymptom extends Model
{
    use SoftDeletes, Accountable;

    protected $table = 'patient_symptoms';

    protected $fillable = [
        'consult_id',
        'symptom_id',
        'patient_id',
    ];

    public function symptom(){
        return $this->belongsTo('App\Models\Symptom\Symptom','symptom_id');
    }
}

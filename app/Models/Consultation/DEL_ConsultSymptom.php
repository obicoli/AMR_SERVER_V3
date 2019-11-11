<?php

namespace App\Models\Consultation;

use Illuminate\Database\Eloquent\Model;

class ConsultSymptom extends Model
{
    //
    protected $table = 'consult_symptoms';

    protected $fillable = [
        'symptom_id',
        'consultation_id',
    ];

}

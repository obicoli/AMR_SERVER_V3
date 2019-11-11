<?php

namespace App\Models\Patient;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HealthProfile extends Model
{
    use SoftDeletes, Accountable, UuidTrait;

    protected $table = 'health_profiles';

    protected $fillable = [
        'current_height',
        'current_weight',
        'any_health_condition',
        'any_medication',
        'any_surgeries_procedures',
        'patient_id',
    ];

    public function patient(){ return $this->belongsTo(Patient::class,'patient_id');}

}

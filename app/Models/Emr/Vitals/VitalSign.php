<?php

namespace App\Models\Emr\Vitals;

use App\Models\Consultation\Consultation;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VitalSign extends Model
{
    use SoftDeletes, Accountable, UuidTrait;

    protected $table = 'vital_signs';

    protected $fillable = [
        'weight',
        'blood_pressure',
        'temperature',
        'resp_rate',
        'consultation_id',
    ];

    public function consultation(){
        return $this->belongsTo(Consultation::class, 'consultation_id');
    }
}

<?php

namespace App\Models\Consultation\Prescription;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultSickNote extends Model
{
    use UuidTrait, SoftDeletes, Accountable;

    protected $table = 'consult_sick_notes';

    protected $fillable = [
        'excusing_activity_id',
        'consultation_id',
        'illiness_explanation',
        'can_resume_when',
    ];

    public function excuse(){
        return $this->belongsTo('App\Models\Consultation\Prescription\ExecuseActivity','excusing_activity_id');
    }

}

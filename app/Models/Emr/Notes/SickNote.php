<?php

namespace App\Models\Emr\Notes;

use App\Models\Consultation\Consultation;
use App\Models\Consultation\Prescription\ExecuseActivity;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SickNote extends Model
{
    use Accountable, UuidTrait, SoftDeletes;

    protected $table = 'sick_notes';

    protected $fillable = [
        'excusing_activity_id',
        'consultation_id',
        'illness_explanation',
        'can_resume_when',
    ];

    public function consultation(){ return $this->belongsTo(Consultation::class, 'consultation_id'); }
    public function excuse(){ return $this->belongsTo(ExecuseActivity::class,'excusing_activity_id'); }

}

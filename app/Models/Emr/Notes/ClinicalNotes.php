<?php

namespace App\Models\Emr\Notes;

use App\Models\Consultation\Consultation;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClinicalNotes extends Model
{
    use SoftDeletes,Accountable, UuidTrait;
    protected $table = 'clinical_notes';

    protected $fillable = [
        'consultation_id',
        'complaint_id',
        'observation_id',
        'diagnose_id',
        'notes',
    ];

    public function consultation(){
        return $this->belongsTo(Consultation::class, 'consultation_id');
    }

    public function complaint(){return $this->belongsTo(Complaint::class,'complaint_id');}
    public function observation(){return $this->belongsTo(Observation::class,'observation_id');}
    public function diagnose(){return $this->belongsTo(Diagnose::class,'diagnose_id');}

}

<?php

namespace App\Models\Consultation;

use App\Models\Conversation\Groups;
use App\Models\Conversation\OnlineTrack;
use App\Models\Doctor\Doctor;
use App\Models\Emr\Notes\ClinicalNotes;
use App\Models\Emr\Notes\Referral;
use App\Models\Emr\Notes\SickNote;
use App\Models\Emr\Orders\LabOrder;
use App\Models\Emr\Prescription\Prescription;
use App\Models\Emr\Vitals\VitalSign;
use App\Models\Patient\Patient;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultation extends Model
{
    use SoftDeletes, Accountable, UuidTrait;

    const VISIT_TYPE_ONLINE = "online";
    const VISIT_TYPE_OFFLINE = "physical";
    const CHAT_SERVICE_NAME = "consultation";
    const MODEL_MORPHY_NAME = "App\Models\Consultation\Consultation";

    protected $table = 'consultations';

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'status',
        'who_is_patient',
        'visit_type',
//        'domain_id',
//        'specialist',
//        'uuid',
//        'status',
//        'time_bound',
//        'time_zone',
//        'who_is_sick',
//        'doctor_preference',
//        'visit_purpose',
//        'when_started_feeling',
//        'taking_any_medications',
//        'any_allergies',
//        'consult_date_time',
//        'refund_patient',
//        'service_id',
//        'consult_duration',
//        'doctor_signature',
    ];

    //consult types
    public function online(){ return $this->hasOne(OnlineConsult::class,'consultation_id'); }
    public function offline(){ return $this->hasOne(OfflineConsult::class,'consultation_id'); }
    //consult users
    public function doctor(){return $this->belongsTo(Doctor::class,'doctor_id','id');}
    public function patient(){return $this->belongsTo(Patient::class,'patient_id','id');}

//    public function payments(){
//        return $this->morphMany('App\Models\Service\Payment', 'payable');
//    }

    public function onlinetrack(){
        return $this->morphMany(OnlineTrack::class, 'traceable');
    }

    public function groups(){
        return $this->morphMany(Groups::class, 'groupable');
    }

    public function conversation(){
        return $this->morphMany('App\Models\Conversation\Conversation', 'conversationable');
    }

    public function calls(){
        return $this->morphMany('App\Models\Conversation\Calls', 'callsable');
    }

//    public function service(){
//        return $this->belongsTo('App\Models\Service\Service','service_id','id');
//    }
//
//    public function doctordomain(){
//        return $this->belongsTo('App\Models\Specialist\Domains','domain_id','id');
//    }
//
//    public function specialist(){
//        return $this->belongsTo('App\Models\Specialist\Specialist','specialist','id');
//    }
//
//    public function symptoms(){
//        return $this->belongsToMany('App\Models\Symptom\Symptom','consult_symptoms','consultation_id','symptom_id');
//    }

//    public function referral(){
//        return $this->hasMany('App\Models\Consultation\Prescription\ConsultRefferal','consultation_id');
//    }

//    public function sicknote(){
//        return $this->hasMany('App\Models\Consultation\Prescription\ConsultSickNote','consultation_id');
//    }

//    public function testorder(){
//        return $this->hasMany('App\Models\Consultation\Prescription\ConsultTestOrder','consultation_id');
//    }

    //Consultation Emr
    public function clinic_notes(){ return $this->hasMany(ClinicalNotes::class,'consultation_id');}
    public function vital_sign(){ return $this->hasMany(VitalSign::class,'consultation_id');}
    public function lab_order(){ return $this->hasMany(LabOrder::class,'consultation_id');}
    public function referral(){ return $this->hasMany(Referral::class,'consultation_id');}
    public function sick_note(){ return $this->hasMany(SickNote::class,'consultation_id');}
    public function prescription(){ return $this->hasMany(Prescription::class,'consultation_id');}

}

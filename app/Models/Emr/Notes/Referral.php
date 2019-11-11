<?php

namespace App\Models\Emr\Notes;

use App\Models\Consultation\Consultation;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Referral extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'referrals';

    protected $fillable = [
        'consultation_id',
        'is_urgent',
        'reason',
        'referral_type',
        'differential_diagnosis',
        'patient_expectation',
    ];

    public function consultation(){ return $this->belongsTo(Consultation::class, 'consultation_id'); }

}

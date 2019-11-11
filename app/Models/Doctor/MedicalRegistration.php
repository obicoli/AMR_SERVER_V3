<?php

namespace App\Models\Doctor;

use App\Models\Users\Assets;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalRegistration extends Model
{
    use SoftDeletes, Accountable, UuidTrait;

    protected $table = 'medical_registrations';

    protected $fillable = [
        'doctor_id',
        'registration_year',
        'approval_status',
        'registration_council',
        'registration_number',
    ];

    public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id');
    }

    public function assets(){
        return $this->morphMany(DoctorAsset::class,'owner','owner_type','owner_id');
    }

}

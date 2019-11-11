<?php

namespace App\Models\Doctor;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorAsset extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $table = 'doctor_assets';

    public function owner(){
        return $this->morphTo();
    }
    //this is to store all: Doctors assets
//
//    public function doctor(){
//        return $this->belongsTo(Doctor::class,'doctor_id');
//    }
}

<?php

namespace App\Models\Doctor;

use App\Models\Users\Assets;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Education extends Model
{
    //
    use SoftDeletes, Accountable, UuidTrait;

    protected $table = 'education';

    protected $fillable = [
        'uuid',
        'degree',
        'institution',
        'year_of_completion',
        'year_of_experience',
        'doctor_id',
        'approval_status',
    ];

    public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id');
    }

    public function assets(){
        return $this->morphMany(DoctorAsset::class,'owner','owner_type','owner_id');
    }

}

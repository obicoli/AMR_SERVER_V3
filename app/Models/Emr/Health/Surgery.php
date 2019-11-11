<?php

namespace App\Models\Emr\Health;

use App\Models\Patient\Patient;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surgery extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'surgeries';

    protected $fillable = [
        'name'
    ];

    public function patient(){ return $this->belongsToMany( Patient::class,'patient_surgery','surgery_id','patient_id'); }
}

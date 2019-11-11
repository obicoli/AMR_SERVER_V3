<?php

namespace App\Models\Doctor;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Availability extends Model
{
    use SoftDeletes, Accountable, UuidTrait;

    protected $table = 'availabilities';

    protected $fillable = [
        'doctor_id',
        'week_day',
        'opening_time',
        'closing_time',
    ];

    public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id');
    }

}

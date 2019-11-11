<?php

namespace App\Models\Specialist;

use App\Models\Doctor\Doctor;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialist extends Model
{
    use SoftDeletes, Accountable;

    protected $table = 'specialists';

    protected $fillable = [
        'domain_id',
        'name',
    ];

    public function domain(){
        return $this->belongsTo('App\Models\Specialist\Domains','domain_id');
    }

    public function doctor(){
        return $this->belongsToMany(Doctor::class,'doctor_specialization','specialization_id','doctor_id');
    }

}

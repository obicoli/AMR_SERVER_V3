<?php

namespace App\Models\Consultation\Prescription;

use Illuminate\Database\Eloquent\Model;

class DoctorAction extends Model
{
    protected $table = 'doctor_actions';

    protected $fillable = [
        'name'
    ];
}

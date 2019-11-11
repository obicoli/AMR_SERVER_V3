<?php

namespace App\Models\Consultation\Prescription;

use Illuminate\Database\Eloquent\Model;

class Classfication extends Model
{
    protected $table = 'classfications';

    protected $fillable = [
        'name'
    ];
}

<?php

namespace App\Models\Consultation;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineConsult extends Model
{
    use SoftDeletes, Accountable, UuidTrait;

    protected $table = 'online_consults';

    protected $fillable = [
        'consultation_id',
        'date_fallen_sick',
        'time_band',
        'any_information',
        'consult_duration',
        'time_zone',
        'start_date',
        'end_date',
    ];

    public function consultation(){ return $this->belongsTo(Consultation::class,'consultation_id'); }

}

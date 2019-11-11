<?php

namespace App\Models\Consultation;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfflineConsult extends Model
{

    use SoftDeletes, Accountable, UuidTrait;

    protected $table = 'offline_consults';

    protected $fillable = [
        'consultation_id'
    ];

    public function consultation(){ return $this->belongsTo(Consultation::class,'consultation_id'); }
}

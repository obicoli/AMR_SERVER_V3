<?php

namespace App\Models\Emr\Orders;

use App\Models\Consultation\Consultation;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabOrder extends Model
{
    use SoftDeletes,UuidTrait,Accountable;

    protected $table = 'lab_orders';

    protected $fillable = [
        'instruction',
        'consultation_id',
    ];

    public function consultation(){ return $this->belongsTo(Consultation::class,'consultation_id'); }
    public function owner(){ return $this->morphTo(); }

}

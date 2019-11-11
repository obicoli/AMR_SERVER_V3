<?php

namespace App\Models\Consultation\Prescription;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultTestOrder extends Model
{
    //
    use UuidTrait, SoftDeletes, Accountable;

    protected $table = 'consult_test_orders';

    protected $fillable = [
        'consultation_id',
        'history',
        'is_urgent',
        'test_name',
        'test_type_id',
    ];

    public function testtype(){
        //return $this->belongsTo('App\Models\TestOrder','test_type_id');
    }
}

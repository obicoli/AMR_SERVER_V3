<?php

namespace App\Models\Consultation\Prescription;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestOrder extends Model
{
    use UuidTrait, SoftDeletes, Accountable;

    protected $table = 'test_orders';

    protected $fillable = [
        'name'
    ];

}

<?php

namespace App\Models\Emr\Treat;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TreatmentPlan extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $table = 'treatment_plans';
    protected $fillable = [
        'consultation_id',
        'proceedure_id',
        'unit',
        'cost_per_unit',
        'discount',
        'notes',
    ];
}

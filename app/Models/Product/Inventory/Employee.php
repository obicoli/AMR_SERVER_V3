<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Practice\Practice;

class Employee extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'employees';

    protected $fillable = [
        'other_name',
        'first_name',
        'address',
        'city',
        'region',
        'notes',
        'phone',
        'mobile',
        'email',
        'bill_rate',
        'billable',
        'national_id',
        'employee_id',
        'gender',
        'date_of_birth',
        'hired_date',
        'released_date',
        'uuid',
        'practice_id',
        'practice_role_id',
    ];

    public function practice(){ return $this->belongsTo(Practice::class, 'practice_id'); }
}

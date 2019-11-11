<?php

namespace App\Models\Practice;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeDepartment extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $table = "practice_departments";
    protected $fillable = [
        'practice_id',
        'status',
        'description',
        'department_id',
    ];
}

<?php

namespace App\Models\Practice;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;

class PracticeType extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $table = "practice_types";
    protected $fillable = [
        'name',
        'description',
        'practice_id',
    ];
}

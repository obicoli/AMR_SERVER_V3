<?php

namespace App\Models\Emr\Notes;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diagnose extends Model
{
    use SoftDeletes, Accountable, UuidTrait;
    protected $table = 'diagnoses';
    protected $fillable = [
        'name'
    ];
}

<?php

namespace App\Models\Emr\Notes;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Observation extends Model
{
    use SoftDeletes, Accountable, UuidTrait;
    protected $table = 'observations';
    protected $fillable = [
        'name'
    ];
}

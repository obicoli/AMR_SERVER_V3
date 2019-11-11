<?php

namespace App\Models\Subscription;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $table = 'plans';

    protected $fillable = [
        ''
    ];
}

<?php

namespace App\Models\Subscription;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RenewalHistory extends Model
{
    use SoftDeletes, Accountable, UuidTrait;
    protected $table = 'renewal_histories';
}

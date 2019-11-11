<?php

namespace App\Models\Practice;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use UuidTrait, Accountable, SoftDeletes;

    protected $table = 'practice_users_profiles';

    protected $fillable = [
        'first_name',
        'other_name',
        'email',
        'mobile',
    ];
}

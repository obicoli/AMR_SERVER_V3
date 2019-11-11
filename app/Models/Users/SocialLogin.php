<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialLogin extends Model
{
    use SoftDeletes;

    protected $table = 'social_logins';

    protected $fillable = [
        'user_id',
        'provider',
        'social_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Users\User');
    }
}

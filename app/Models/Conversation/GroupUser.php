<?php

namespace App\Models\Conversation;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    const ONLINE = "online";
    const OFFLINE = "offline";

    protected $table = 'group_users';

    protected $fillable = [
        'group_id',
        'user_id',
        'created_by_user_id',
        'updated_by_user_id',
    ];

    public function user(){
        return $this->belongsTo('App\Models\Users\User','user_id','id');
    }

    public function groups(){
        return $this->belongsTo('App\Models\Groups','group_id','id');
    }
}

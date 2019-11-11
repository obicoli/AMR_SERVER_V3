<?php

namespace App\Models\Conversation;

use App\Models\Users\User;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Groups extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    const DEFAULT_AVATAR = "/assets/images/profile/group_icon.jpg";
    const MODEL_MORPHY_NAME = "App\Models\Conversation\Groups";

    protected $table = 'groups';

    protected $fillable = [
        'name',
        'status',
        'groupable_type',
        'created_by_user_id',
        'updated_by_user_id',
        'groupable_id'
    ];

    public function user(){ return $this->belongsToMany(User::class,'group_users','group_id','user_id'); }
    public function groupuser(){return $this->hasMany(GroupUser::class,'group_id');}
    public function groupable(){return $this->morphTo();}
    public function onlinetrack(){return $this->morphMany(OnlineTrack::class, 'traceable');}

}

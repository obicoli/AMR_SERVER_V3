<?php

namespace App\Models\Conversation;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{

    use UuidTrait, SoftDeletes;

    protected $table = 'conversations';

    protected $fillable = [
        'message',
        'status',
        'started_at',
        'started_at',
        'ended_at',
        'user_id',
        'group_id',
        'room_id',
        'uuid',
        'conversationable_id',
        'conversationable_type',
    ];

    public function conversationable(){
        return $this->morphTo('conversation','conversationable_type','conversationable_id','id');
    }

    public function user(){
        return $this->belongsTo('App\Models\Users\User','user_id','id');
    }

    public function groups(){
        return $this->belongsTo('App\Models\Conversation\Groups','group_id','id');
    }

    public function conversationeventlistener(){
        return $this->hasMany('App\Models\ConversationEventListener','conversation_id');
    }

}

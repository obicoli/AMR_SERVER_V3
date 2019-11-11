<?php

namespace App\Models\Conversation;

use Illuminate\Database\Eloquent\Model;

class ConversationEventListener extends Model
{

    protected $table = 'conversation_event_listeners';

    protected $fillable = [
        'user_id', //user id who read message
        'conversation_id', //message conversation
        'group_id', //group containing all users intended
        'action_', //action taken by user Received/Rejected Call
        'mailbox_id', //action taken by user Received/Rejected Call
    ];



    public function group(){
        return $this->belongsTo('App\Models\Users\Group','group_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\Users\User','user_id');
    }

    public function conversation(){
        return $this->belongsTo('App\Models\Users\Conversation','conversation_id');
    }

}

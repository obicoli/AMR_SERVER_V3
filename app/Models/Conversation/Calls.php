<?php

namespace App\Models\Conversation;

use Illuminate\Database\Eloquent\Model;

class Calls extends Model
{
    protected $table = 'calls';

    protected $fillable = [
        'file',
        'started_at',
        'ended_at',
        'user_id',
        'group_id',
        'uuid',
        'callsable_id',
        'callsable_type',
        'status',
    ];

    public function callsable(){
        return $this->morphTo('calls','callable_type','callable_id','id');
    }

}

<?php

namespace App\Models\Conversation;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class OnlineTrack extends Model
{
    use UuidTrait;

    protected $table = 'online_tracks';

    protected $fillable = [
        'resource_id',
        'user_id',
        'first_name',
        'last_name',
        'traceable_id',
        'traceable_type',
        'salute',
        'avatar',
        'date_seen',
        'group_id',
        'room_id',
        'uuid',
        'status',
    ];

    public function traceable(){
        return $this->morphTo();
    }

}

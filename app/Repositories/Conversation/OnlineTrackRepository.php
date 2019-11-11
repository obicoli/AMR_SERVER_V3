<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/22/18
 * Time: 1:29 PM
 */

namespace App\Repositories\Conversation;


use App\Models\Conversation\Groups;
use App\Models\Conversation\OnlineTrack;

class OnlineTrackRepository implements OnlineTrackRepositoryInterface
{

    protected $onlinetrack;

    public function __construct(OnlineTrack $onlineTrack)
    {
        $this->onlinetrack = $onlineTrack;
    }

    public function store(array $arr)
    {
        // TODO: Implement store() method.
        return $this->onlinetrack->create($arr);
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
        return $this->onlinetrack->find($id)->delete();
    }

    public function destroyByResourceId($resource_id)
    {
        // TODO: Implement destroyByResourceId() method.
//        $online_party = $this->onlinetrack->where('resource_id', $resource_id)->get()->first();
//        $online_party->status = "offline";
//        $online_party->save();
//        return $online_party;
        return $this->onlinetrack->where('resource_id', $resource_id)->delete();
    }


    public function find($id)
    {
        // TODO: Implement find() method.
        return $this->onlinetrack->find($id);
    }

    public function findByRecourceId($resource_id)
    {
        // TODO: Implement findByRecourceId() method.
        return $this->onlinetrack->all()->where('resource_id', $resource_id)->first();
    }

    public function findByUserId($user_id)
    {
        // TODO: Implement findByUserId() method.
        return $this->onlinetrack->all()->where('user_id', $user_id)->first();
    }


    public function checkIfUserAlreadyLoggedIn($user_id, $resource_id)
    {
        // TODO: Implement checkIfUserAlreadyLoggedIn() method.
        return $this->onlinetrack->all()->where('resource_id', $resource_id)->where('user_id',$user_id)->first();
    }


    public function all()
    {
        // TODO: Implement all() method.
        return $this->onlinetrack->all();
    }

    public function findTrackable(OnlineTrack $onlineTrack)
    {
        // TODO: Implement findTrackable() method.
        return $onlineTrack->traceable()->get()->first();
    }

    public function trace_status($user_id)
    {
        // TODO: Implement trace_status() method.
        $check = $this->onlinetrack->all()->where('user_id', $user_id)->first();
        if ($check){
            return "online";
        }else{
            return "offline";
        }
    }

    public function createNewOnlineUser(array $arr)
    {
        // TODO: Implement createNewOnlineUser() method.
        return $this->onlinetrack->create($arr);
    }

    public function getOnlineParties($room_id)
    {
        // TODO: Implement getOnlineParties() method.
        return $this->onlinetrack->all()->where('room_id', $room_id);
    }


}

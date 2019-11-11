<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/22/18
 * Time: 1:29 PM
 */

namespace App\Repositories\Conversation;


use App\Models\Conversation\OnlineTrack;

interface OnlineTrackRepositoryInterface
{

    public function store(array $arr);
    public function destroy($id);
    public function destroyByResourceId($resource_id);
    public function find($id);
    public function findByRecourceId($resource_id);
    public function findByUserId($user_id);
    public function all();
    public function findTrackable(OnlineTrack $onlineTrack);
    public function trace_status($user_id);
    public function checkIfUserAlreadyLoggedIn($user_id, $resource_id);
    public function createNewOnlineUser(array $arr);
    public function getOnlineParties($room_id);

}

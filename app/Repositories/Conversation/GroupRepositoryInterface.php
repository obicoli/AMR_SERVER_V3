<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/23/18
 * Time: 9:08 AM
 */

namespace App\Repositories\Conversation;

use App\Models\Conversation\Groups;
use App\Models\Users\User;

interface GroupRepositoryInterface
{

    public function store(array $arr);
    public function find($id);
    public function delete($id);
    public function all();
    public function setGroupUser(array $arr);
    public function setUserLastSeen($user_id);
    public function getUsers(Groups $groups);
    public function getUserGroups(User $user);
    public function groupMembers(Groups $groups);
    public function getAvatar(Groups $groups);
    public function is_generated(Groups $groups);

}

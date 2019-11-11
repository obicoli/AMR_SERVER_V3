<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/23/18
 * Time: 9:08 AM
 */

namespace App\Repositories\Conversation;


use App\Models\Conversation\Groups;
use App\Models\Conversation\GroupUser;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupRepository implements GroupRepositoryInterface
{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function store(array $arr)
    {
        // TODO: Implement store() method.
        return $this->model->create($arr);
    }

    public function find($id)
    {
        // TODO: Implement find() method.
        return $this->model->find($id);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function setGroupUser(array $arr)
    {
        // TODO: Implement setGroupUser() method.
        return $this->model->create($arr);
    }

    public function setUserLastSeen($user_id)
    {
        // TODO: Implement setUserLastSeen() method.
        DB::table('group_users')
            ->where('user_id', $user_id)
            ->update(['last_seen' => date("Y-m-d H:i:s")]);
    }


    public function getUsers(Groups $groups)
    {
        // TODO: Implement getUsers() method.
        return $groups->user()->get();
    }

    public function getUserGroups(User $user)
    {
        // TODO: Implement getUserGroups() method.
        return $user->groups()->get();
    }


    public function groupMembers(Groups $groups)
    {
        // TODO: Implement groupMembers() method.
        return DB::table('group_users')->where('group_id', $groups->id)->get();
    }


    public function getAvatar(Groups $groups)
    {
        // TODO: Implement getAvatar() method.
        return Groups::DEFAULT_AVATAR;
    }


    public function is_generated(Groups $groups)
    {
        // TODO: Implement is_generated() method.
        if ($groups->is_generated){
            return true;
        }
        return false;
    }


}

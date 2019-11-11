<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 1/25/19
 * Time: 11:24 AM
 */

namespace App\Repositories\Practice;


use App\Models\Practice\Practice;
use App\Models\Practice\PracticeUsers;
use App\Models\Users\User;
use jeremykenedy\LaravelRoles\Models\Role;

class PracticeUserRepository implements PracticeUserRepositoryInterface
{
    protected $practiceUsers;

    public function __construct(PracticeUsers $practiceUsers)
    {
        $this->practiceUsers = $practiceUsers;
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function attachRole(PracticeUsers $practiceUsers, Role $role)
    {
        // TODO: Implement attachRole() method.
        $practiceUsers->attachRole($role);
        $permissions = $role->permissions()->get();
        foreach ($permissions as $permission){
            $practiceUsers->attachPermission($permission);
        }
    }

    public function findPracticeUser(Practice $practice, User $user)
    {
        // TODO: Implement findPracticeUser() method.
        return $this->practiceUsers->all()
            ->where('practice_id',$practice->id)
            ->where('user_id',$user->id)
            ->first();
    }

    public function setConfirmed(PracticeUsers $practiceUsers, $confirmed = true)
    {
        // TODO: Implement setConfirmed() method.
        $practiceUsers->confirmed = $confirmed;
        $practiceUsers->save();
    }

    public function getByPracticeId($id)
    {
        // TODO: Implement getByPracticeUuid() method.
        return $this->practiceUsers->where('practice_id',$id)->orderByDesc('created_at')->paginate(10);
    }


}

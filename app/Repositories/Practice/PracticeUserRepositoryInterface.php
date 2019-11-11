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

interface PracticeUserRepositoryInterface
{

    public function find($id);
    public function attachRole(PracticeUsers $practiceUsers, Role $role);
    public function findPracticeUser(Practice $practice, User $user);
    public function setConfirmed(PracticeUsers $practiceUsers, $confirmed=true);
    public function getByPracticeId($id);

}

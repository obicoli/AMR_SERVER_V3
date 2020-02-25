<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/14/18
 * Time: 3:58 PM
 */

namespace App\Repositories\User;


use App\Models\Practice\Practice;
use App\Models\Users\User;

interface UserRepositoryInterface
{

    public function storeRecord(array $arr);

    public function storeRecords(array $arr);

    public function findRecord($id);

    public function find($id);

    public function getRecord();

    //public function setRecord(array $arr, $id);

    public function findByEmail($email);

    public function getByEmail($email);

    public function findByEmailOrMobile($email_or_mobile);

    public function findByPhone($mobile);

    public function findByUuid($uuid);

    public function isPatient(User $user);

    public function isDoctor(User $user);

    public function isAdmin(User $user);

    public function isSystemAdmin(User $user);

    public function activated(User $user);

    public function findByToken($token);

    public function activateUser(User $user);

    public function deleteByUserId($user_id);

    public function setPassword(User $user, array $arr);

    public function setProfile(User $user, array $arr);

    public function getProfile(User $user);

    public function update(array $arr, $uuid);

    public function delete($uuid);

    public function attachRole(User $user, $slug);

    public function getAvatar(User $user);

    public function attachToPractice(User $user, Practice $practice);

    public function detachFromPractice(User $user, Practice $practice);

    public function exist_in_practice(User $user, Practice $practice);

    public function setPractice(User $user, $arr);

    public function getPractice(User $user);

    public function setDoctor(User $user, array $arr);

    public function setPatient(User $user, array $arr);

    public function setReceptionist(User $user, array $arr);

    //public function deleteFromPracticeUsers(User $user);

    public function setNewPatient(array $arr);

    public function createProfile(array $arr);

    public function getUserType(User $user);

    public function createPassword($string_);

    public function getAccounts(User $user);

    public function getPermissions(User $user);

    public function getCreatedBy(User $user);

}

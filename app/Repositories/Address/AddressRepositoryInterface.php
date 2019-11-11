<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 3/7/19
 * Time: 1:01 PM
 */

namespace App\Repositories\Address;


use App\Models\Users\User;

interface AddressRepositoryInterface
{

    public function all();
    public function create(array $arr);
    public function update(array $arr, $uuid);
    public function delete($uuid);
    public function find($id);
    public function findByUuid($uuid);
    public function getByUser(User $user);
    public function deleteByUuid($uuid);
    public function updateByUuid(array $arr, $uuid);

}
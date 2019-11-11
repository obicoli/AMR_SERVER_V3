<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 3/7/19
 * Time: 1:00 PM
 */

namespace App\Repositories\Address;


use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class AddressRepository implements AddressRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function create(array $arr)
    {
        // TODO: Implement create() method.
        return $this->model->create($arr);
    }

    public function update(array $arr, $uuid)
    {
        // TODO: Implement update() method.
    }

    public function delete($uuid)
    {
        // TODO: Implement delete() method.
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function findByUuid($uuid)
    {
        // TODO: Implement findByUuid() method.
    }

    public function getByUser(User $user)
    {
        // TODO: Implement getByUser() method.
        return $user->delivery_address()->get()->sortByDesc('created_at');
    }

    public function deleteByUuid($uuid)
    {
        // TODO: Implement deleteByUuid() method.
        $this->model->get()->where('uuid',$uuid)->first()->delete();
    }

    public function updateByUuid(array $arr, $uuid)
    {
        // TODO: Implement updateByUuid() method.
        $this->model->get()->where('uuid',$uuid)->first()->update($arr);
    }


}
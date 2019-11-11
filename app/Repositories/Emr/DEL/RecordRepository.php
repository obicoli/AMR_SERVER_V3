<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 3/27/19
 * Time: 1:00 PM
 */

namespace App\Repositories\Emr;


use Illuminate\Database\Eloquent\Model;

class RecordRepository implements RecordRepositoryInterface
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

    public function store(array $arr)
    {
        // TODO: Implement store() method.
    }

    public function update(array $arr, $id)
    {
        // TODO: Implement update() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function findByUuid($uuid)
    {
        // TODO: Implement findByUuid() method.
    }


}
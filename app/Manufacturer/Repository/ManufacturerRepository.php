<?php


namespace App\Manufacturer\Repository;


use Illuminate\Database\Eloquent\Model;

class ManufacturerRepository implements ManufacturerRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        // TODO: Implement all() method.
        return $this->model->all();
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function findByUuid($uuid)
    {
        // TODO: Implement findByUuid() method.
        return $this->model->where('uuid',$uuid)->get()->first();
    }

}
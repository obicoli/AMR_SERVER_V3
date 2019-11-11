<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 3/12/19
 * Time: 10:26 AM
 */

namespace App\Repositories\Emr\Prescription;


use App\Models\Records\Prescription\Prescription;
use Illuminate\Database\Eloquent\Model;

class PrescriptionRepository implements PrescriptionRepositoryInterface
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
        return $this->model->newQuery()->create($arr);
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

    public function store_assets(Prescription $prescription, array $arr = [])
    {
        // TODO: Implement store_assets() method.
        return $prescription->assets()->create($arr);
    }


}
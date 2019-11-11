<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 1/22/19
 * Time: 8:42 AM
 */

namespace App\Repositories\Consultation\Prescription;


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
        return $this->model->all();//->sortBy('name');
    }

    public function findByUuid($uuid)
    {
        // TODO: Implement findByUuid() method.
    }

    public function destroy($uuid)
    {
        // TODO: Implement destroy() method.
        return $this->model->where('uuid',$uuid)->delete();
    }

}

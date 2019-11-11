<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 3/28/19
 * Time: 1:26 PM
 */

namespace App\Repositories\Emr;


use App\Repositories\Emr\EmrRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class EmrRepository implements EmrRepositoryInterface
{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all($_PAGINATE = 0, $_SORT_ORDER = null)
    {
        // TODO: Implement all() method.
        return $this->model->all()->sortBy('name');
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
        return $this->model->all()->where('uuid',$uuid)->first();
    }

    public function transform_collection($collections)
    {
        // TODO: Implement transaform_collection() method.
        $results = array();
        foreach ($collections as $collection){
            $temp_data['id'] = $collection->uuid;
            $temp_data['name'] = $collection->name;
            array_push($results, $temp_data);
        }
        return $results;
    }


}
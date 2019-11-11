<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/17/18
 * Time: 1:15 AM
 */

namespace App\Repositories\Symptom;


use App\Models\Symptom\SymptomCategory;
use Illuminate\Database\Eloquent\Model;

class SymptomRepository implements SymptomRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        // TODO: Implement all() method.
        return $this->model->all()->sortBy('name');
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function store(array $arr)
    {
        // TODO: Implement store() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }

    public function update(array $arr, $id)
    {
        // TODO: Implement update() method.
    }

    public function get_category_symptoms(SymptomCategory $symptomCategory)
    {
        // TODO: Implement get_category_symptoms() method.
        return $symptomCategory->symptom()->get()->sortBy('name');
    }


    public function transform_collection($collections)
    {
        // TODO: Implement transform_collection() method.
        $results = array();

        foreach ($collections as $collection){

            $temp_data['id'] = $collection->uuid;
            $temp_data['name'] = $collection->name;
            array_push($results, $temp_data);
        }

        return $results;
    }

    public function transform_category_collection($collections)
    {
        // TODO: Implement transform_category_collection() method.
        $results = array();

        foreach ($collections as $collection){
            $temp_data['id'] = $collection->uuid;
            $temp_data['name'] = $collection->name;
            $temp_data['symptoms'] = $this->transform_symptom_collection($this->get_category_symptoms($collection));
            array_push($results, $temp_data);
        }

        return $results;
    }

    public function transform_symptom_collection($collections)
    {
        // TODO: Implement transform_symptom_collection() method.
        $results = array();

        foreach ($collections as $collection){
            $temp_data['id'] = $collection->uuid;
            $temp_data['name'] = $collection->name;
            array_push($results, $temp_data);
        }

        return $results;
    }


}

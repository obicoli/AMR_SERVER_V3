<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 2/19/19
 * Time: 12:20 PM
 */

namespace App\Repositories\Manufacturer;


use App\Models\Manufacturer\Manufacturer;
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
        return $this->model->all()->sortBy('name');
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function findByUuid($uuid)
    {
        // TODO: Implement findByUuid() method.
    }

    public function findByName($name)
    {
        // TODO: Implement findByName() method.
        return $this->model->all()->where('name',$name)->first();
    }


    public function store(array $arr)
    {
        // TODO: Implement store() method.
        if($arr['name']){
            $manufacture = $this->model->all()->where('name',$arr['name'])->first();
            if($manufacture){
                return $manufacture;
            }
            return $this->model->create($arr);
        }else{
            return null;
        }

    }

    public function update(array $arr, $uuid)
    {
        // TODO: Implement update() method.
    }

    public function destroy($uuid)
    {
        // TODO: Implement destroy() method.
    }

    public function transform_(Manufacturer $manufacturer)
    {
        // TODO: Implement transform_() method.
        return [
            'id' => $manufacturer->uuid,
            'name' => $manufacturer->name,
        ];
    }

    public function transform_collection($collections)
    {
        // TODO: Implement transform_collection() method.
        $results = array();
        foreach ($collections as $collection){
            array_push($results, $this->transform_($collection));
        }
        return $results;
    }


}

<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/18/18
 * Time: 2:44 PM
 */

namespace App\Repositories\Services\Service;


use App\Models\Service\Service;

class ServiceRepository implements ServiceRepositoryInterface
{

    protected $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function all()
    {
        // TODO: Implement all() method.
        return $this->service->all();
    }

    public function store(array $arr)
    {
        // TODO: Implement store() method.
    }

    public function destroy($uuid)
    {
        // TODO: Implement destroy() method.
    }

    public function update(array $arr, $uuid)
    {
        // TODO: Implement update() method.
    }

    public function find($id)
    {
        // TODO: Implement find() method.
        return $this->service->find($id);
    }

    public function getCharge(Service $service){
        // TODO: Implement getCharge() method.
        $res = array();
        $charges = $service->service_charge()->get();
        foreach ($charges as $charge){
            $temp_['id'] = $charge->uuid;
            $temp_['service_type'] = $charge->service_type;
            $temp_['cost'] = $charge->cost;
            $temp_['slug'] = $charge->slug;
            array_push($res, $temp_);
        }
        return $res;
    }


    public function transform_collection($collections)
    {
        // TODO: Implement transform_collection() method.
        $results = array();

        foreach ($collections as $collection){
            $temp_data['id'] = $collection->uuid;
            $temp_data['name'] = $collection->name;
            $temp_data['slug'] = $collection->slug;
            $temp_data['description'] = $collection->description;
            $temp_data['pricing'] = $this->getCharge($collection);
            array_push($results, $temp_data);
        }

        return $results;
    }


}

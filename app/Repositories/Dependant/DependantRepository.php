<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 3/1/19
 * Time: 12:11 PM
 */

namespace App\Repositories\Dependant;


use App\Models\Dependant\Dependant;
use App\Models\Patient\Patient;

class DependantRepository implements DependantRepositoryInterface
{
    protected $dependant;

    public function __construct(Dependant $dependant)
    {
        $this->dependant = $dependant;
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function store(array $arr)
    {
        // TODO: Implement store() method.
        return $this->dependant->create($arr);
    }

    public function update(array $arr, $uuid)
    {
        // TODO: Implement update() method.
        return $this->dependant->all()->where('uuid',$uuid)->first()->update($arr);
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function findByUuid($id)
    {
        // TODO: Implement findByUuid() method.
    }

    public function deleteByUuid($uuid)
    {
        // TODO: Implement deleteByUuid() method.
        return $this->dependant->where('uuid',$uuid)->get()->first()->delete();
    }

    public function transform_collection($dependants)
    {
        // TODO: Implement transform_collection() method.

        $results = array();

        foreach ($dependants as $dependant){
            $temp_data['id'] = $dependant->uuid;
            $temp_data['first_name'] = $dependant->first_name;
            $temp_data['other_name'] = $dependant->other_name;
            $temp_data['relationship'] = $dependant->relationship;
            $temp_data['address'] = $dependant->address;
            $temp_data['gender'] = $dependant->gender;
            $temp_data['age'] = $dependant->age;
            $temp_data['phone'] = $dependant->phone;
            array_push($results, $temp_data);
        }

        return $results;

    }


}
<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 3/6/19
 * Time: 2:28 PM
 */

namespace App\Repositories\Localization;

use App\Models\Localization\Country;
use Illuminate\Database\Eloquent\Model;

class LocalizationRepository implements LocalizationRepositoryInterface
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

    public function create(array $arr)
    {
        // TODO: Implement create() method.
    }

    public function find($id)
    {
        // TODO: Implement find() method.
        return $this->model->find($id);
    }

    public function findByUuid($uuid)
    {
        // TODO: Implement findByUuid() method.
        return $this->model->all()->where('uuid',$uuid)->first();

    }


    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }

    public function update(array $arr, $id)
    {
        // TODO: Implement update() method.
    }

    public function findByCountryId($country_id)
    {
        // TODO: Implement findByCountryId() method.
        return $this->model->all()->where('country_id',$country_id)->sortBy('name');
    }

    public function findByName($name)
    {
        // TODO: Implement findByName() method.
        return $this->model->all()->where('name',$name)->first();
    }

    public function transform_country(Country $country){
        return [
            'id'=>$country->uuid,
            'name'=>$country->name,
            'code'=>$country->code,
            'currency'=>$country->currency,
            'currency_sympol'=>$country->currency_sympol,
            'display_as'=>$country->currency_sympol."-".$country->currency,
        ];
    }


}
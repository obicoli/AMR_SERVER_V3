<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/18/18
 * Time: 2:55 PM
 */

namespace App\Transformers\Services;


use App\Models\Service\Service;

class ServiceTransformer
{

    public function transform(Service $service){
        return [

        ];
    }

    public function transformCollection($collections){

        $results = array();

        foreach ($collections as $collection){

            $temp_data['id'] = $collection->id;
            $temp_data['slug'] = $collection->slug;
            $temp_data['name'] = $collection->name;
            $temp_data['fees'] = $collection->fees;
            $temp_data['description'] = $collection->description;
            $temp_data['uuid'] = $collection->uuid;
            array_push($results, $temp_data);
        }

        return $results;

    }

}

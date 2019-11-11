<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/16/18
 * Time: 8:59 PM
 */

namespace App\Transformers\Specialist;


use App\Models\Specialist\Domains;

class SpecialistTransformer
{

    public function tranformDomainCollection($collections){
        $results = array();
        foreach ($collections as $collection){
            $temp_data['id'] = $collection->id;
            $temp_data['name'] = $collection->name;
            $temp_data['specialists'] = $this->getDomainSpecialists($collection);
            array_push($results, $temp_data);
        }
        return $results;
    }

    public function tranformSpecialistCollection($collections){
        $results = array();
        foreach ($collections as $collection){
            $temp_data['id'] = $collection->id;
            $temp_data['name'] = $collection->name;
            $temp_data['domain_id'] = $collection->domain()->first()->id;
            $temp_data['domain_name'] = $collection->domain()->first()->name;
            array_push($results, $temp_data);
        }
        return $results;
    }

    public function getDomainSpecialists(Domains $domains){
        $results = array();
        foreach (  $domains->specialist()->get() as $item ){
            $temp_data['id'] = $item->id;
            $temp_data['name'] = $item->name;
            array_push($results,$temp_data);
        }
        return $results;
    }

}

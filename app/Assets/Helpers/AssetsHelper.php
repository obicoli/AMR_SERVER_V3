<?php
/**
     * Created by IntelliJ IDEA.
     * User: collins
     * Date: 09/10/18
     * Time: 7:41 PM
 */
namespace App\Assets\Helpers;

use App\Assets\Models\Machines\Vehicle\Vehicle;

class AssetsHelper{

    public function transform_vehicle(Vehicle $vehicle){
        return [
            'id'=>$vehicle->uuid,
            'name'=>$vehicle->vhc_name,
            'number'=>$vehicle->vhc_number,
            'vid'=>$vehicle->vhc_id,
        ];
    }

}
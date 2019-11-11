<?php
/**
     * Created by IntelliJ IDEA.
     * User: collins
     * Date: 09/10/18
     * Time: 7:41 PM
 */
namespace App\Hrs\Helpers;

use App\Hrs\Models\Employee\HrsEmployee;

class HrsHelper{

    public function transform_employee(HrsEmployee $hrsEmployee){

        return [
            'id' => $hrsEmployee->uuid,
            'first_name' => $hrsEmployee->first_name,
            'last_name' => $hrsEmployee->last_name,
        ];

    }

}

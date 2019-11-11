<?php

namespace App\Http\Controllers\Api\Referral;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class ReferalPartinerController extends Controller
{
    protected $response_type;

    public function __construct()
    {
        $this->response_type = Config::get('response.http');
    }

    public function index(){

        $http_resp = $this->response_type['200'];

        $data2 = array();
        $data['name'] = 'The Karen Hospital';
        $data['type'] = 'Pri/Sec/Tertiary';
        $data['discount'] = '10% Off';
        $data['locations'] = 'See 1 location';
        $data['website'] = '/';
        $data2[0] = $data;
        $data['name'] = 'Lancet Labs';
        $data['type'] = 'Lab';
        $data['discount'] = '10% Off';
        $data['locations'] = 'See 1 location';
        $data['website'] = '/';
        $data2[1] = $data;
        $data['name'] = 'PharmaLab';
        $data['type'] = 'Pharmacy';
        $data['discount'] = '10% Off';
        $data['locations'] = 'See 5 location';
        $data['website'] = '/';
        $data2[2] = $data;
        $data['name'] = 'Kenya Red Cross';
        $data['type'] = 'Emergency';
        $data['discount'] = 'Ksh600 Pickup + Ksh5500 Return';
        $data['locations'] = 'Call 0000000000';
        $data['website'] = '/';
        $data2[3] = $data;
        //return $data2;

        $http_resp['results'] = $data2;
        return response()->json($http_resp);
    }
}

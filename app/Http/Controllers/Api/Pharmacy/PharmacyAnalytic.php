<?php

namespace App\Http\Controllers\Api\Pharmacy;

use App\Models\Pharmacy\Pharmacy;
use App\Repositories\ModelRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PharmacyAnalytic extends Controller
{
    protected $pharmacy;
    protected $model;

    public function __construct(Pharmacy $pharmacy)
    {
        $this->model = new ModelRepository($pharmacy);
    }

    public function index(){

        $http_resp = $this->response_type['200'];

        $totals = array();
        $actives = array();
        $inactives = array();
        $directs = array();
        $referal = array();
        $referal_direct = array();

        $response['labels'] = ['Mon', 'Tue', 'Wen', 'Thu', 'Fri','Sat','Sun'];
        array_push($totals,20000);
        array_push($totals,50000);
        array_push($totals,3000);
        array_push($totals,15000);
        array_push($totals,7000);
        array_push($totals,5000);
        array_push($totals,10000);
        $response['total'] = $totals;

        $http_resp['results'] = $response;

        return response()->json($http_resp);

    }

}

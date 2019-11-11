<?php

namespace App\Http\Controllers\Api\Consultation\Prescription;

use App\Models\Consultation\Prescription\PrescriptionRoute;
use App\Repositories\Consultation\Prescription\PrescriptionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class PrescriptionRouteController extends Controller
{
    protected $prescriptionRoute;
    protected $http_response;

    public function __construct(PrescriptionRoute $prescriptionRoute)
    {
        $this->prescriptionRoute = new PrescriptionRepository($prescriptionRoute);
        $this->http_response = Config::get('response.http');
    }

    public function index(){

        $http_resp = $this->http_response['200'];
        $http_resp['results'] = $this->prescriptionRoute->all();
        return response()->json($http_resp);
    }
}

<?php

namespace App\Http\Controllers\Api\Consultation\Prescription;

use App\Models\Consultation\Prescription\DoctorAction;
use App\Repositories\Consultation\Prescription\PrescriptionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class RecommendationsController extends Controller
{
    protected $doctorAction;
    protected $http_response;

    public function __construct(DoctorAction $doctorAction)
    {
        $this->doctorAction = new PrescriptionRepository($doctorAction);
        $this->http_response = Config::get('response.http');
    }

    public function index(){
        $http_resp = $this->http_response['200'];
        $http_resp['results'] = $this->doctorAction->all();
        return response()->json($http_resp);
    }

}

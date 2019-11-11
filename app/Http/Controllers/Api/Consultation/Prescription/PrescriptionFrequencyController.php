<?php

namespace App\Http\Controllers\Api\Consultation\Prescription;

use App\Models\Consultation\Prescription\PrescriptionFrequency;
use App\Repositories\Consultation\Prescription\PrescriptionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class PrescriptionFrequencyController extends Controller
{
    protected $prescriptionFrequency;
    protected $http_response;

    public function __construct(PrescriptionFrequency $prescriptionFrequency)
    {
        $this->prescriptionFrequency = new PrescriptionRepository($prescriptionFrequency);
        $this->http_response = Config::get('response.http');
    }

    public function index(){

        $http_resp = $this->http_response['200'];
        $http_resp['results'] = $this->prescriptionFrequency->all();
        return response()->json($http_resp);
    }
}

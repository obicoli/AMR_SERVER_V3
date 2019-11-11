<?php

namespace App\Http\Controllers\Api\Consultation\Prescription;

use App\Models\Consultation\Prescription\PrescriptionForm;
use App\Repositories\Consultation\Prescription\PrescriptionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class PrescriptionFormController extends Controller
{
    protected $prescriptionForm;
    protected $http_response;

    public function __construct(PrescriptionForm $prescriptionForm)
    {
        $this->prescriptionForm = new PrescriptionRepository($prescriptionForm);
        $this->http_response = Config::get('response.http');
    }

    public function index(){

        $http_resp = $this->http_response['200'];
        $http_resp['results'] = $this->prescriptionForm->all();
        return response()->json($http_resp);
    }

}

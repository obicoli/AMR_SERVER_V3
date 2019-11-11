<?php

namespace App\Http\Controllers\Api\Consultation\Prescription;

use App\helpers\HelperFunctions;
use App\Models\Consultation\Consultation;
use App\Models\Consultation\Prescription\TestOrder;
use App\Repositories\Consultation\ConsultationRepository;
use App\Repositories\Consultation\Prescription\PrescriptionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class TestOrderController extends Controller
{
    protected $testOrder;
    protected $http_response;
    protected $helpers;
    protected $consultation;

    public function __construct(TestOrder $testOrder)
    {
        $this->testOrder = new PrescriptionRepository($testOrder);
        $this->consultation = new ConsultationRepository(new Consultation());
        $this->http_response = Config::get('response.http');
        $this->helpers = new HelperFunctions();
    }

    public function create(Request $request){

        $http_resp = $this->http_response['200'];

        $rules = [
            'history' => 'required',
            'is_urgent' => 'required',
            'test_name' => 'required',
            'test_type_id' => 'required',
            'consult_id' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helpers->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        $consult = $this->consultation->findByUid($request->consult_id);
        $this->consultation->setTestOrder($consult, $request->all());
        return response()->json($http_resp);
    }

    public function index(){
        $http_resp = $this->http_response['200'];
        $http_resp['results'] = $this->testOrder->all();
        return response()->json($http_resp);
    }

    public function getConsultTestOrders($uuid){
        $consult = $this->consultation->findByUid($uuid);
        $http_resp = $this->http_response['200'];
        $http_resp['results'] = $this->consultation->getTestOrder($consult);
        return response()->json($http_resp);
    }

}

<?php

namespace App\Http\Controllers\Api\Consultation\Prescription;
use App\helpers\HelperFunctions;
use App\Http\Controllers\Controller;

use App\Models\Consultation\Consultation;
use App\Models\Consultation\Prescription\ConsultPrescription;
use App\Repositories\Consultation\ConsultationRepository;
use App\Repositories\Consultation\Prescription\PrescriptionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class PrescriptionController extends Controller
{

    protected $consultPrescription;
    protected $consultation;
    protected $http_response;
    protected $helpers;

    public function __construct(ConsultPrescription $consultPrescription)
    {
        $this->consultPrescription = new PrescriptionRepository($consultPrescription);
        $this->http_response = Config::get('response.http');
        $this->helpers = new HelperFunctions();
        $this->consultation = new ConsultationRepository(new Consultation());
    }

    public function create(Request $request){

        $http_resp = $this->http_response['200'];

        $rules = [
            'name' => 'required',
            'dosage' => 'required',
            'administration_duration' => 'required',
            'patient_direction' => 'required',
            'consult_id' => 'required',
            'form_id' => 'required',
            'frequency_id' => 'required',
            'route_id' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helpers->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        $consult = $this->consultation->findByUid($request->consult_id);
        $this->consultation->setPrescription($consult, $request->all());
        return response()->json($http_resp);

    }

    public function getConsultPrescription($uuid){
        $consult = $this->consultation->findByUid($uuid);
        $http_resp = $this->http_response['200'];
        $http_resp['results'] = $this->consultation->getPrescription($consult);
        return response()->json($http_resp);
    }

    public function destroy($uuid){
        $http_resp = $this->http_response['200'];
        $this->consultPrescription->destroy($uuid);
        return response()->json($http_resp);
    }

}

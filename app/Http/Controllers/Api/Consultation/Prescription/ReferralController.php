<?php

namespace App\Http\Controllers\Api\Consultation\Prescription;

use App\helpers\HelperFunctions;
use App\Models\Consultation\Consultation;
use App\Models\Consultation\Prescription\ConsultRefferal;
use App\Repositories\Consultation\ConsultationRepository;
use App\Repositories\Consultation\Prescription\PrescriptionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReferralController extends Controller
{

    protected $consultRefferal;
    protected $consultation;
    protected $http_response;
    protected $helpers;

    public function __construct(ConsultRefferal $consultRefferal)
    {
        $this->consultRefferal = new PrescriptionRepository($consultRefferal);
        $this->http_response = Config::get('response.http');
        $this->helpers = new HelperFunctions();
        $this->consultation = new ConsultationRepository(new Consultation());
    }

    public function create(Request $request){

        $http_resp = $this->http_response['200'];

        $rules = [
            'reason' => 'required',
            'referal_type' => 'required',
            'differential_diagnosis' => 'required',
            'patient_expectation' => 'required',
            'is_urgent' => 'required',
            'consult_id' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helpers->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        $consult = $this->consultation->findByUid($request->consult_id);
        $this->consultation->setReferral($consult, $request->all());
        return response()->json($http_resp);

    }

    public function destroy($uuid){
        $http_resp = $this->http_response['200'];
        $this->consultRefferal->destroy($uuid);
        return response()->json($http_resp);
    }

    public function getConsultReferrals($uuid){
        $consult = $this->consultation->findByUid($uuid);
        $http_resp = $this->http_response['200'];
        $http_resp['results'] = $this->consultation->getReferral($consult);
        return response()->json($http_resp);
    }

}

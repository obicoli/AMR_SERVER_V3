<?php

namespace App\Http\Controllers\Api\Consultation;

use App\helpers\HelperFunctions;
use App\Models\Consultation\Consultation;
use App\Models\Consultation\PatientSymptom;
use App\Models\Users\Patient;
use App\Repositories\Consultation\ConsultationRepository;
use App\Repositories\Consultation\PatientSymptomRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Patient\PatientRepository;
use App\Transformers\Consultation\ConsultationTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class PatientSymptomController extends Controller
{
    protected $patientSymptom;
    protected $consultation;
    protected $http_response;
    protected $helper;
    protected $transformer;
    protected $patient;

    public function __construct(PatientSymptom $patientSymptom, Consultation $consultation, Patient $patient)
    {
        $this->patientSymptom = new PatientSymptomRepository($patientSymptom);
        $this->consultation = new ConsultationRepository($consultation);
        $this->patient = new PatientRepository($patient);
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->transformer = new ConsultationTransformer();
    }

    public function store(Request $request){

    }

    public function update(Request $request){

    }

    public function setConsultationSymptoms(Request $request, $consultation_uid){
        Log::info($consultation_uid);
        Log::info($request);
        $consult = $this->consultation->findByUid($consultation_uid);
        Log::info($consult);
        $patient = $this->patient->findPatientByUserId($request->user()->id);
        if ( is_array($request->patient_symptoms) ){
            $this->patientSymptom->insert($this->transformer->createConsultationSymptoms($request, $consult,$patient));
            $http_resp = $this->http_response['200'];
            return response()->json($http_resp);
        }else{
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ['Patient symptoms should be an array'];
            return response()->json($http_resp, 422);
        }
    }

}

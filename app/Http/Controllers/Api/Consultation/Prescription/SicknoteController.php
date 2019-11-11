<?php

namespace App\Http\Controllers\Api\Consultation\Prescription;

use App\helpers\HelperFunctions;
use App\Models\Consultation\Consultation;
use App\Models\Consultation\Prescription\ConsultSickNote;
use App\Repositories\Consultation\ConsultationRepository;
use App\Repositories\Consultation\Prescription\PrescriptionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class SicknoteController extends Controller
{
    protected $consultSickNote;
    protected $http_response;
    protected $helpers;
    protected $consultation;

    public function __construct(ConsultSickNote $consultSickNote)
    {
        $this->consultSickNote = new PrescriptionRepository($consultSickNote);
        $this->consultation = new ConsultationRepository(new Consultation());
        $this->http_response = Config::get('response.http');
        $this->helpers = new HelperFunctions();
    }

    public function create(Request $request){

        $http_resp = $this->http_response['200'];

        $rules = [
            'excusing_activity_id' => 'required',
            'illiness_explanation' => 'required',
            'can_resume_when' => 'required',
            'consult_id' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helpers->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        if ( !$this->helpers->isPastDate($request->can_resume_when) ){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ['Resuming must be a past date'];
            return response()->json($http_resp,422);
        }

        $consult = $this->consultation->findByUid($request->consult_id);
        $this->consultation->setSicknote($consult, $request->all());
        return response()->json($http_resp);
    }

    public function getConsultSicknotes($uuid){
        $consult = $this->consultation->findByUid($uuid);
        $http_resp = $this->http_response['200'];
        $http_resp['results'] = $this->consultation->getSicknote($consult);
        return response()->json($http_resp);
    }

}

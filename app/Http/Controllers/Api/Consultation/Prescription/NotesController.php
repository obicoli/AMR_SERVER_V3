<?php

namespace App\Http\Controllers\Api\Consultation\Prescription;

use App\helpers\HelperFunctions;
use App\Models\Consultation\Consultation;
use App\Models\Consultation\Prescription\ConsultNote;
use App\Repositories\Consultation\ConsultationRepository;
use App\Repositories\Consultation\Prescription\PrescriptionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class NotesController extends Controller
{
    //
    protected $consultNote;
    protected $http_response;
    protected $helpers;
    protected $consultation;

    public function __construct(ConsultNote $consultNote)
    {
        $this->consultNote = new PrescriptionRepository($consultNote);
        $this->consultation = new ConsultationRepository(new Consultation());
        $this->http_response = Config::get('response.http');
        $this->helpers = new HelperFunctions();
    }

    public function create(Request $request){

        $http_resp = $this->http_response['200'];

        $rules = [
            'classification_id' => 'required',
            'internal_notes' => 'required',
            'patient_notes' => 'required',
            'doctor_action_id' => 'required',
            'consult_id' => 'required',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helpers->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        $consult = $this->consultation->findByUid($request->consult_id);
        if (!$this->consultation->getNotes($consult)->count()){
            $this->consultation->setNotes($consult, $request->all());
        }
        return response()->json($http_resp);

    }

}

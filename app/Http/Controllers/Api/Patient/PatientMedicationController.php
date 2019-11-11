<?php

namespace App\Http\Controllers\Api\Patient;

use App\helpers\HelperFunctions;
use App\Models\Emr\Health\Medication;
use App\Models\Patient\Patient;

use App\Repositories\Emr\EmrRepository;
use App\Repositories\Patient\PatientRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PatientMedicationController extends Controller
{
    protected $patient;
    protected $medication;
    protected $response_type;
    protected $transformer;
    protected $helper;

    public function __construct(Patient $patient)
    {
        $this->patient = new PatientRepository($patient);
        $this->medication = new EmrRepository(new Medication());
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function index(){}

    public function show($uuid){
        $http_resp = $this->response_type['200'];
    }

    public function create(Request $request){

        $http_resp = $this->response_type['200'];
        $rule = [
            'patient_id' => 'required',
            'medication_id' => 'required',
            'dosage' => 'required',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ( $validate->fails() ){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validate->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{
            $patient = $this->patient->findByUuid($request->patient_id);
            $medication = $this->medication->findByUuid($request->medication_id);
            if ($this->patient->setMedications($patient, $medication, $request->all())){
                $http_resp['description'] = "Medication successful added";
            }else{
                $http_resp['description'] = "Medication already exists";
            }
            $http_resp['results'] = $this->patient->getMedications($patient);
        }catch (\Exception $exception){
            $http_resp = $this->response_type['500'];
            Log::info($exception);
            DB::rollBack();
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp,200);

    }

    public function destroy($patient_id, $medication_id){
        $http_resp = $this->response_type['200'];
        $patient = $this->patient->findByUuid($patient_id);
        $medication = $this->medication->findByUuid($medication_id);
        $this->patient->deleteMedication($patient, $medication);
        $http_resp['description'] = 'Medication dropped successful';
        $http_resp['results'] = $this->patient->getMedications($patient);
        return response()->json($http_resp,200);
    }

    public function update(Request $request, $uuid){
        $http_resp = $this->response_type['200'];
    }

}

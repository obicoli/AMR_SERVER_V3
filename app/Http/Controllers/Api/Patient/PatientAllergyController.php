<?php

namespace App\Http\Controllers\Api\Patient;

use App\helpers\HelperFunctions;
use App\Models\Emr\Health\Allergies;
use App\Models\Patient\Patient;
use App\Repositories\Emr\EmrRepository;
use App\Repositories\Patient\PatientRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PatientAllergyController extends Controller
{
    protected $patient;
    protected $allergies;
    protected $response_type;
    protected $transformer;
    protected $helper;

    public function __construct(Patient $patient)
    {
        $this->patient = new PatientRepository($patient);
        $this->allergies = new EmrRepository(new Allergies());
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function index(){}
    public function create(Request $request){

        $http_resp = $this->response_type['200'];

        $rule = [
            'patient_id' => 'required',
            'allergy_id' => 'required',
            'severity' => 'required',
            'reaction' => 'required',
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
            $allergy = $this->allergies->findByUuid($request->allergy_id);
            if ( $this->patient->setAllergy($patient, $allergy, $request->all()) ){
                $http_resp['description'] = "Allergy successful added";
            }else{
                $http_resp['description'] = "Allergy already exists";
            }
            $http_resp['results'] = $this->patient->getAllergy($patient);
        }catch (\Exception $exception){
            $http_resp = $this->response_type['500'];
            Log::info($exception);
            DB::rollBack();
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp,200);

    }

    public function destroy($patient_id, $allergy_id){
        $http_resp = $this->response_type['200'];
        $patient = $this->patient->findByUuid($patient_id);
        $allergy = $this->allergies->findByUuid($allergy_id);
        $this->patient->deleteAllergies($patient, $allergy);
        $http_resp['description'] = 'Allergy dropped successful';
        $http_resp['results'] = $this->patient->getAllergy($patient);
        return response()->json($http_resp,200);
    }
    public function update(Request $request){}

    public function show($uuid){
        $http_resp = $this->response_type['200'];
    }
}

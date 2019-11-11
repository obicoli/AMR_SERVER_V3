<?php

namespace App\Http\Controllers\Api\Patient;

use App\helpers\HelperFunctions;
use App\Models\Emr\Health\HealthCondition;
use App\Models\Patient\Patient;
use App\Repositories\Emr\EmrRepository;
use App\Repositories\Patient\PatientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class PatientConditionController extends Controller
{
    protected $patient;
    protected $condition;
    protected $response_type;
    protected $transformer;
    protected $helper;

    public function __construct(Patient $patient)
    {
        $this->patient = new PatientRepository($patient);
        $this->condition = new EmrRepository(new HealthCondition());
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function index(){}

    public function destroy($patient_id, $condition_id){
        $http_resp = $this->response_type['200'];
        $patient = $this->patient->findByUuid($patient_id);
        $condition = $this->condition->findByUuid($condition_id);
        $this->patient->deleteConditions($patient, $condition);
        $http_resp['description'] = 'Condition dropped successful';
        $http_resp['results'] = $this->patient->getConditions($patient);
        return response()->json($http_resp,200);
    }

    public function create(Request $request){

        $http_resp = $this->response_type['200'];
        $rule = [
            'patient_id' => 'required',
            'condition_id' => 'required',
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
            $condition = $this->condition->findByUuid($request->condition_id);
            if ( $this->patient->setConditions($patient, $condition, $request->all()) ){
                $http_resp['description'] = "Condition added successful";
            }else{
                $http_resp['description'] = "Condition already exists";
            }
            $http_resp['results'] = $this->patient->getConditions($patient);
        }catch (\Exception $exception){
            $http_resp = $this->response_type['500'];
            Log::info($exception);
            DB::rollBack();
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp,200);
    }

    public function show($uuid){
        $http_resp = $this->response_type['200'];
    }

    public function update(Request $request, $uuid){
        $http_resp = $this->response_type['200'];
    }

}

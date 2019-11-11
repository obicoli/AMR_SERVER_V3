<?php

namespace App\Http\Controllers\Api\Patient;

use App\helpers\HelperFunctions;
use App\Models\Emr\Health\Surgery;
use App\Models\Patient\Patient;
use App\Repositories\Emr\EmrRepository;
use App\Repositories\Patient\PatientRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PatientSurgeryController extends Controller
{
    protected $patient;
    protected $surgery;
    protected $response_type;
    protected $transformer;
    protected $helper;

    public function __construct(Patient $patient)
    {
        $this->patient = new PatientRepository($patient);
        $this->surgery = new EmrRepository(new Surgery());
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
            'surgery_id' => 'required',
            'year' => 'required',
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
            $surgery = $this->surgery->findByUuid($request->surgery_id);
            if ($this->patient->setSurgery($patient, $surgery, $request->all())){
                $http_resp['description'] = "Surgery added successful";
            }else{
                $http_resp['description'] = "Surgery already exists";
            }
            $http_resp['results'] = $this->patient->getSurgery($patient);
        }catch (\Exception $exception){
            $http_resp = $this->response_type['500'];
            Log::info($exception);
            DB::rollBack();
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp,200);

    }

    public function destroy($patient_id, $surgery_id){
        $http_resp = $this->response_type['200'];
        $patient = $this->patient->findByUuid($patient_id);
        $surgery = $this->surgery->findByUuid($surgery_id);
        $this->patient->deleteSurgery($patient, $surgery);
        $http_resp['description'] = 'Surgery dropped successful';
        $http_resp['results'] = $this->patient->getSurgery($patient);
        return response()->json($http_resp,200);
    }

    public function update(Request $request, $uuid){
        $http_resp = $this->response_type['200'];
    }
}

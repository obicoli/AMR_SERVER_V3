<?php

namespace App\Http\Controllers\Api\Dependant;

use App\helpers\HelperFunctions;
use App\Models\Dependant\Dependant;
use App\Models\Doctor\Doctor;
use App\Models\Patient\Patient;
use App\Models\Users\User;
use App\Repositories\Dependant\DependantRepository;
use App\Repositories\ModelRepository;
use App\Repositories\Patient\PatientRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DependantController extends Controller
{
    protected $dependant;
    protected $model;
    protected $patient;
    protected $user;
    protected $response_type;
    protected $helpers;

    public function __construct(Dependant $dependant)
    {
        $this->dependant = new DependantRepository($dependant);
        $this->model = new ModelRepository($dependant);
        $this->patient = new PatientRepository(new Patient());
        $this->user = new UserRepository(new User());
        $this->helpers = new HelperFunctions();
        $this->response_type = Config::get('response.http');
    }

    public function index(Request $request){
        $http_resp = $this->response_type['200'];
        $user = $request->user();
        $results = array();
        switch ($this->user->getUserType($user)){
            case Patient::USER_TYPE:
                $dependables = Patient::all()->where('user_id',$user->id)->first();
                $dependants = $this->patient->getDependant($dependables);
                $results = $this->dependant->transform_collection($dependants);
                break;
            case Doctor::USER_TYPE:
                $dependables = Doctor::all()->where('user_id',$user->id)->first();
                break;
        }
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }

    public function create(Request $request){
        $http_resp = $this->response_type['200'];
        $rule = [
            'first_name' => 'required',
            'patient_id' => 'required',
            'other_name' => 'required',
            'gender' => 'required',
            'relationship' => 'required',
            'age' => 'required',
        ];
        $validator = Validator::make($request->all(),$rule);
        if ($validator->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helpers->getValidationErrors($validator->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{
            $user = $request->user();
            switch ($this->user->getUserType($user)){
                case Patient::USER_TYPE:
                    $patient = $this->patient->findByUuid($request->patient_id);
                    $dependant = $this->patient->createDependant($patient, $request->except('patient_id'));
                    break;
            }
        }catch (\Exception $e){
            Log::info($e);
            DB::rollBack();
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function update(Request $request, $uuid){
        $http_resp = $this->response_type['200'];
        $rule = [
            'first_name' => 'required',
            'other_name' => 'required',
            'gender' => 'required',
            'relationship' => 'required',
            'age' => 'required',
        ];
        $validator = Validator::make($request->all(),$rule);
        if ($validator->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helpers->getValidationErrors($validator->errors());
            return response()->json($http_resp,422);
        }
        DB::beginTransaction();
        try{
            $this->dependant->update($request->all(), $uuid);
        }catch (\Exception $e){
            Log::info($e);
            DB::rollBack();
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function destroy($uuid){
        $http_resp = $this->response_type['200'];
        $this->dependant->deleteByUuid($uuid);
        return response()->json($http_resp);
    }
    public function show($uuid){}

}

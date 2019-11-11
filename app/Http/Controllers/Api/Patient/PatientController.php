<?php

namespace App\Http\Controllers\Api\Patient;

use App\helpers\HelperFunctions;
use App\Models\Patient\Patient;
use App\Repositories\Patient\PatientRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    protected $patient;
    protected $response_type;
    protected $transformer;
    protected $helper;

    public function __construct(Patient $patient)
    {
        $this->patient = new PatientRepository($patient);
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function index(){}
    public function destroy($uuid){}
    public function create(Request $request){}

    public function show($uuid){
        $http_resp = $this->response_type['200'];
        $patient = $this->patient->findByUuid($uuid);
        $http_resp['results'] = $this->patient->transform_profile($patient);
        return response()->json($http_resp);
    }

    public function update(Request $request, $uuid){

        $http_resp = $this->response_type['200'];
        $patient = $this->patient->findByUuid($uuid);
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required|in:Male,Female,Other',
            'dob' => 'required',
        ];
        if (!$this->helper->isPastDate($request->dob)){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = ['Date of birth must be a past date'];
            return response()->json($http_resp,422);
        }
        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        $this->patient->update($patient, $request->all());
        return response()->json($http_resp);

    }
}

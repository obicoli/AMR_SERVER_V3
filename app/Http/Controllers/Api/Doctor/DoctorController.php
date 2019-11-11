<?php

namespace App\Http\Controllers\Api\Doctor;

use App\helpers\HelperFunctions;
use App\Models\Doctor\MedicalRegistration;
use App\Models\Doctor\Doctor;
use App\Repositories\Doctor\DoctorRepository;
use App\Repositories\Doctor\MedicalRegistrationRepository;
use App\Repositories\ModelRepository;
use App\Transformers\User\DoctorTransformer;
use App\Transformers\User\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    //
    protected $doctor;
    protected $response_type;
    protected $transformer;
    protected $helper;
    protected $medicalRegistration;
    protected $model;

    public function __construct(Doctor $doctor)
    {
        $this->doctor = new DoctorRepository($doctor);
        $this->model = new ModelRepository($doctor);
        $this->response_type = Config::get('response.http');
        $this->transformer = new DoctorTransformer();
        $this->helper = new HelperFunctions();
        $this->medicalRegistration = new MedicalRegistrationRepository(new MedicalRegistration());
    }

    public function index(){
        $http_resp = $this->response_type['200'];
        $doctors = $this->model->all(0,Doctor::FIRST_NAME);
        $http_resp['results'] = $this->doctor->transform_collection($doctors);
        return response()->json($http_resp);
    }

    public function show(Request $request, $uuid){
        $http_resp = $this->response_type['200'];
        $doctor = $this->doctor->findByUuid($uuid);
        $http_resp['results'] = $this->transformer->transform($doctor);
        return response()->json($http_resp);
    }

    public function update(Request $request, $uuid){
        $http_resp = $this->response_type['200'];
        $doctor = $this->doctor->findByUuid($uuid);
        $rules = [
            'specialist' => 'sometimes|required',
            'first_name' => 'sometimes|required',
            'last_name' => 'sometimes|required',
            'own_practice' => 'sometimes|required',
            'registration_number' => 'sometimes|required|unique:doctors,registration_number,'.$doctor->registration_number,
            'gender' => 'sometimes|required|in:Male,Female,Other',
        ];
        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        $this->doctor->update($doctor, $request->all());
        return response()->json($http_resp);
    }

}

<?php

namespace App\Http\Controllers\Api\Doctor;

use App\helpers\HelperFunctions;
use App\Models\Doctor\MedicalRegistration;
use App\Repositories\Doctor\MedicalRegistrationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MedicalRegistrationController extends Controller
{

    protected $medicalRegistration;
    protected $response_type;
    protected $helper;

    public function __construct(MedicalRegistration $medicalRegistration)
    {
        $this->medicalRegistration = new MedicalRegistrationRepository($medicalRegistration);
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function update(Request $request, $uuid){

        $http_resp = $this->response_type['200'];

        $record = $this->medicalRegistration->findByUuid($uuid);
        $rules = [
            'registration_year' => 'required',
            'registration_council' => 'required',
            'registration_number' => 'required|unique:medical_registrations,registration_number,'.$record->id,
        ];

        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        $this->medicalRegistration->update($request->all(),$uuid);
        return response()->json($http_resp);

    }

    public function create(Request $request){

    }

}

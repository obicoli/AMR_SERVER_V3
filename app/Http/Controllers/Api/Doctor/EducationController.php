<?php

namespace App\Http\Controllers\Api\Doctor;

use App\helpers\HelperFunctions;
use App\Models\Doctor\Education;
use App\Repositories\Doctor\EducationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class EducationController extends Controller
{
    //
    protected $education;
    protected $response_type;
    protected $helper;

    public function __construct(Education $education)
    {
        $this->education = new EducationRepository($education);
        $this->helper = new HelperFunctions();
        $this->response_type = Config::get('response.http');
    }

    public function update(Request $request,$uuid){
        $http_resp = $this->response_type['200'];
        $rules = [
            'degree' => 'sometimes|required',
            'year_of_experience' => 'required',
            'institution' => 'required',
            'year_of_completion' => 'required',
        ];
        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        $this->education->update($request->all(), $uuid);
        return response()->json($http_resp);
    }

}

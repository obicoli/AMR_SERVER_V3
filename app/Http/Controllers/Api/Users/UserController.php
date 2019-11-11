<?php

namespace App\Http\Controllers\Api\Users;

use App\helpers\HelperFunctions;
use App\Models\Doctor\Education;
use App\Models\Doctor\MedicalRegistration;
use App\Models\Users\Assets;
use App\Models\Users\User;
use App\Repositories\Doctor\EducationRepository;
use App\Repositories\Doctor\MedicalRegistrationRepository;
use App\Repositories\User\AssetRepository;
use App\Repositories\User\UserRepository;
use App\Transformers\User\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $user;
    protected $transformer;
    protected $response_type;
    protected $helper;
    protected $assets;
    protected $medicalRegistration;
    protected $education;

    public function __construct()
    {
        $this->user = new UserRepository(new User());
        $this->transformer = new UserTransformer();
        $this->assets = new AssetRepository(new Assets());
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->medicalRegistration = new MedicalRegistrationRepository(new MedicalRegistration());
        $this->education = new EducationRepository(new Education());
    }

    public function index(){
        $http_resp = $this->response_type['200'];
        $http_resp['results'] = $this->transformer->transformCollection($this->user->getRecord());
        return response()->json($http_resp);
    }

    public function create(Request $request){

        $http_resp = $this->response_type['200'];
        $validation = Validator::make($request->all(),$this->transformer->createUserRule());
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{
            $new_user = $this->user->storeRecord($request->all());
            $this->user->attachRole($new_user, $request->account_type);
            //save profile picture assets
            $this->assets->save($new_user, new Assets());
            $this->user->setProfile($new_user, $request->all());
        }catch (\Exception $e){
            $http_resp = $this->response_type['500'];
            DB::rollBack();
            Log::info($e);
            return response()->json($http_resp, 500);
        }
        DB::commit();
        return response()->json($http_resp);

    }

    public function update(Request $request, $uuid){

        $http_resp = $this->response_type['200'];
        $user = $this->user->findByUuid($uuid);

        $rules = [
            'email' => 'required|email|unique:users,email,'.$user->id,
            'mobile' => 'required|unique:users,mobile,'.$user->id,
            'username' => 'required|unique:users,username,'.$user->id,
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'email' => 'sometimes|required|email|unique:users,email,'.$user->id,
                'mobile' => 'sometimes|required|unique:users,mobile,'.$user->id,
                'username' => 'sometimes|required|unique:users,username,'.$user->id,
            ];
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validator->errors());
            return response()->json($http_resp,422);
        }

        $this->user->update($request->all(), $uuid);
        return response()->json($http_resp);
    }

    public function destroy($uuid){
        $http_resp = $this->response_type['200'];
        $this->user->delete($uuid);
        return response()->json($http_resp);
    }

    public function show($uuid){
        $http_resp = $this->response_type['200'];
        $user = $this->user->findByUuid($uuid);
        Log::info($uuid);
        //$results = $this->transformer->showProfile($user);
        //$results['profile'] = $this->user->getProfile($user);
//        if ($this->user->isDoctor($user)){
//            $results['medical_registration'] = $this->medicalRegistration->findByUser($user)->toArray();
//            $results['education'] = $this->education->findByUser($user)->toArray();
//        }
        $http_resp['results'] = $user;
        return response()->json($http_resp);
    }

}

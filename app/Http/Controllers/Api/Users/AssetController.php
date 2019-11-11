<?php

namespace App\Http\Controllers\Api\Users;

use App\helpers\HelperFunctions;
use App\Models\Doctor\Education;
use App\Models\Doctor\MedicalRegistration;
use App\Models\Practice\Practice;
use App\Models\Users\Assets;
use App\Models\Users\User;
use App\Repositories\Doctor\EducationRepository;
use App\Repositories\Doctor\MedicalRegistrationRepository;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\User\AssetRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AssetController extends Controller
{

    protected $assets;
    protected $user;
    protected $education;
    protected $medical_registration;
    protected $practice;
    protected $response_type;
    protected $helper;

    public function __construct(Assets $assets)
    {
        $this->assets = new AssetRepository($assets);
        $this->user = new UserRepository(new User());
        $this->education = new EducationRepository(new Education());
        $this->medical_registration = new MedicalRegistrationRepository(new MedicalRegistration());
        $this->practice = new PracticeRepository(new Practice());
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function store(Request $request){

        $http_resp = $this->response_type['200'];
        $rule = [
            'asset_type' => 'required|in:Profile picture,National ID,Passport,Alien ID,Education degree,Medical registration,Practice licence',
            'file' => 'required',
        ];
        $validation = Validator::make($request->all(), $rule);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        $user = $this->user->findRecord($request->user()->id);

        $doc_tmp_name = $_FILES['file']['tmp_name'];
        $file_path = '';
        $strg = strtolower($request->asset_type);
        $strg = preg_replace('/\s+/', '_', $strg);

        switch ($request->asset_type){

            case 'Profile picture':
                if ( $this->assets->isAssetExist($user,$request->asset_type) ){
                    $http_resp = $this->response_type['422'];
                    $http_resp['errors'] = [$request->asset_type.' already exist'];
                    return response()->json($http_resp,422);
                }
                $model = $user;
                $file_path = '/img/profile/'.$user->id.'_'.$strg.'_'.$_FILES['file']['name'];
                break;
            case 'National ID':
                if ( $this->assets->isAssetExist($user,$request->asset_type) ){
                    $http_resp = $this->response_type['422'];
                    $http_resp['errors'] = [$request->asset_type.' already exist'];
                    return response()->json($http_resp,422);
                }
                $model = $user;
                $file_path = '/img/identity/'.$user->id.'_'.$_FILES['file']['name'];
                break;
            case 'Education degree':
                $education = $this->education->findByUserId($request->user()->id);
                if ( $this->assets->isAssetExist($education,$request->asset_type) ){
                    $http_resp = $this->response_type['422'];
                    $http_resp['errors'] = [$request->asset_type.' already exist'];
                    return response()->json($http_resp,422);
                }
                $model = $education;
                $file_path = '/img/education/'.$user->id.'_'.$_FILES['file']['name'];
                break;
            case 'Medical registration':
                $medical = $this->medical_registration->findByUserId($request->user()->id);
                if ( $this->assets->isAssetExist($medical,$request->asset_type) ){
                    $http_resp = $this->response_type['422'];
                    $http_resp['errors'] = [$request->asset_type.' already exist'];
                    return response()->json($http_resp,422);
                }
                $model = $medical;
                $file_path = '/img/medical/'.$user->id.'_'.$_FILES['file']['name'];
                break;
            case 'Practice licence':
                $practice = $this->practice->findByUser($user);
                if ( $this->assets->isAssetExist($practice,$request->asset_type) ){
                    $http_resp = $this->response_type['422'];
                    $http_resp['errors'] = [$request->asset_type.' already exist'];
                    return response()->json($http_resp,422);
                }
                $model = $practice;
                $file_path = '/img/practices/'.$user->id.'_'.$_FILES['file']['name'];
                break;
        }


        //$assets = $this->assets->findByUuid($uuid);
        $newFilePath = $_SERVER['DOCUMENT_ROOT'].$file_path;
        $asset = $request->all();
        $asset['file_path'] = $file_path;
        $asset['file_mime'] = $_FILES['file']['type'];
        $asset['file_name'] = $_FILES['file']['name'];
        $asset['file_size'] = $_FILES['file']['size'];

        if(move_uploaded_file($doc_tmp_name, $newFilePath)){
            //$this->assets->update($asset, $assets->id);
            $this->assets->create($model, $asset);
            return response()->json($http_resp);
        }else{
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
    }

    public function update(Request $request, $uuid){

        $http_resp = $this->response_type['200'];
        $rule = [
            'asset_type' => 'required',
            'file' => 'required',
        ];
        $validation = Validator::make($request->all(), $rule);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        $assets = $this->assets->findByUuid($uuid);
        $doc_tmp_name = $_FILES['file']['tmp_name'];
        $file_path = '/img/profile/'.$assets->id.'_'.$_FILES['file']['name'];
        $newFilePath = $_SERVER['DOCUMENT_ROOT'].$file_path;
        $asset = $request->all();
        $asset['file_path'] = $file_path;
        $asset['file_mime'] = $_FILES['file']['type'];
        $asset['file_name'] = $_FILES['file']['name'];
        $asset['file_size'] = $_FILES['file']['size'];
        if(move_uploaded_file($doc_tmp_name, $newFilePath)){
            $this->assets->update($asset, $assets->id);
            return response()->json($http_resp);
        }else{
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
    }

    public function get_assets_type(Request $request, $type){

        $http_resp = $this->response_type['200'];

        switch ($type){

            case 'identity':
                $user = $this->user->findRecord($request->user()->id);
                $assets = $this->assets->getByModel($user)->toArray();
                $http_resp['results'] = $assets;
                break;
            case 'education':
                $education = $this->education->findByUserId($request->user()->id);
                $assets = $this->assets->getByModel($education)->toArray();
                $http_resp['results'] = $assets;
                break;
            case 'medical':
                $medical = $this->medical_registration->findByUserId($request->user()->id);
                $assets = $this->assets->getByModel($medical)->toArray();
                $http_resp['results'] = $assets;
                break;
            case 'practice_licence':
                $practice = $this->practice->findByUser($request->user());
                $assets = $this->assets->getByModel($practice)->toArray();
                $http_resp['results'] = $assets;
                break;
        }
        return response()->json($http_resp);
    }

//    foreach ($files as $file) {
//        if (file_exists($file)) {
//            unlink($file);
//        } else {
//            // File not found.
//        }
//    }

    //$string = preg_replace('/\s+/', '_', $string);

}

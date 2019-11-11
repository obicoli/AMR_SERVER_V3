<?php

namespace App\Http\Controllers\Api\Consultation;

use App\helpers\HelperFunctions;
use App\Models\Consultation\MedicalAsset;
use App\Models\Users\User;
use App\Repositories\Consultation\MedicalAssetsRepository;
use App\Repositories\User\UserRepository;
use App\Traits\ActivationTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MedicalAssetsController extends Controller
{

    protected $medicalAsset;
    protected $response_type;
    protected $helper;
    protected $settings;
    protected $user;
    use ActivationTrait;

    public function __construct(MedicalAsset $medicalAsset)
    {
        $this->medicalAsset = new MedicalAssetsRepository($medicalAsset);
        $this->user = new UserRepository(new User());
        $this->response_type = Config::get('response.http');
        $this->settings = Config::get('settings.application');
        $this->helper = new HelperFunctions();
    }

    public function index(Request $request){

        $current_user = $this->user->findRecord($request->user()->id);
        $medical_assets = $this->medicalAsset->getByUser($current_user);
        $data_arr = array();
        $http_resp = $this->response_type['200'];
        foreach ($medical_assets as $medical_asset){
            $temp_data['uuid'] = $medical_asset->uuid;
            $temp_data['asset_title'] = $medical_asset->asset_title;
            $temp_data['asset_type'] = $medical_asset->asset_type;
            $temp_data['file_path'] = $medical_asset->file_path;
            $temp_data['file_mime'] = $medical_asset->file_mime;
            $temp_data['file_name'] = $medical_asset->file_name;
            $temp_data['file_size'] = $medical_asset->file_size;
            $temp_data['created_at'] = (string)$medical_asset->created_at;
            if ($current_user->id == $medical_asset->created_by_user_id){
                $temp_data['shared_by'] = null;
            }else{
                $shared_user = $this->user->findRecord($medical_asset->created_by_user_id);
                $temp_data['shared_by'] = $shared_user->email;
            }
            array_push($data_arr, $temp_data);
        }
        $response = [
            'pagination' => [
                'total' => $medical_assets->total(),
                'per_page' => $medical_assets->perPage(),
                'current_page' => $medical_assets->currentPage(),
                'last_page' => $medical_assets->lastPage(),
                'from' => $medical_assets->firstItem(),
                'to' => $medical_assets->lastItem()
            ],
            'data' => $data_arr
        ];
        $http_resp['results'] = $response;
        return response()->json($http_resp);

    }

    public function create(Request $request){

        $current_user = $this->user->findRecord($request->user()->id);
        $http_resp = $this->response_type['200'];
        $rule = [
            'asset_title' => 'required',
            'asset_type' => 'required',
            'file' => 'required|max:500000',
        ];
        $validation = Validator::make($request->all(), $rule);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        $doc_tmp_name = $_FILES['file']['tmp_name'];
        $file_path = '/medical/assets/'.$current_user->id.'_'.$_FILES['file']['name'];
        $newFilePath = $_SERVER['DOCUMENT_ROOT'].$file_path;
        $asset = $request->all();
        $asset['file_path'] = $file_path;
        $asset['file_mime'] = $_FILES['file']['type'];
        $asset['file_name'] = $_FILES['file']['name'];
        $asset['file_size'] = $_FILES['file']['size'];
        if(move_uploaded_file($doc_tmp_name, $newFilePath)){
            $this->medicalAsset->create($current_user, $asset);
            return response()->json($http_resp);
        }else{
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }

    }

    public function share(Request $request){

        $current_user = $this->user->findRecord($request->user()->id);
        $http_resp = $this->response_type['200'];
        $rule = [
            'recipient_mobile' => 'required',
            'recipient_name' => 'required',
            'record_uuid' => 'required',
        ];
        $validation = Validator::make($request->all(), $rule);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{

            $inputs = $request->except(['record_uuid']);
            $inputs['user_id'] = $request->user()->id;
            $inputs['status'] = 'success';
            $inputs['message'] = 'success';

            $shared_to_user = $this->user->findByPhone($request->recipient_mobile);
            $shared_medical_asset = $this->medicalAsset->findByUuid($request->record_uuid);
            $user_profile = $this->user->getProfile($current_user);

            $url = "";

            if (!$shared_to_user){
                //setup this user account. default is patient
                $new_in['mobile'] = $request->recipient_mobile;
                $shared_to_user = $this->user->setNewPatient($new_in);
                $url = $this->settings['domain']."/oauth/login/".$shared_to_user->uuid."/create/password";
            }else{
                if ($this->user->isPatient($shared_to_user)){
                    //$url = "https://stackoverflow.com/questions/5799392/using-bitly-api-to-shorten-urls";
                    $url = $this->settings['domain']."/dashboard/".$shared_to_user->uuid."/records";
                }elseif ($this->user->isDoctor($shared_to_user)){
                    $url = $this->settings['domain']."/dashboard/".$shared_to_user->uuid."/records";
                }
            }

            $url = $this->helper->bitly_shorten($url);
            $message = "Hi ".$request->recipient_name."\n".$user_profile['first_name'].
                " has shared medical record(s) with you.\n"."Click here to view: ".
                $url." ".$this->settings['name']." TCs applicable";
            $inputs['message'] = $message;
            //save notification
            $this->medicalAsset->create_notification_sms($shared_medical_asset, $inputs);
            //create/share to the user
            $this->medicalAsset->save($shared_to_user, $shared_medical_asset);
            //initiate sending of the sms
            $send_sms = $this->initiateSms($request->recipient_mobile,$message);
            if ($send_sms == 'send'){
                DB::commit();
                $http_resp = $this->response_type['200'];
                return response()->json($http_resp);
            }else{
                DB::rollBack();
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = [$send_sms];
                return response()->json($http_resp,422);
            }
        }catch (\Exception $e){
            Log::info($e);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
    }

    public function destroy($uuid){

        Log::info($uuid);
        $http_resp = $this->response_type['200'];
        $this->medicalAsset->destroy($uuid);
        return response()->json($http_resp);

    }

}

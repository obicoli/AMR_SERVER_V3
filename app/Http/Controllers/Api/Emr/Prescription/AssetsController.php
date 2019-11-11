<?php

namespace App\Http\Controllers\Api\Records\Prescription;

use App\helpers\HelperFunctions;
use App\Logic\Files\Uploads;
use App\Models\Patient\Patient;
use App\Models\Users\User;
use App\Repositories\Patient\PatientRepository;
use App\Repositories\User\UserRepository;
use App\Transformers\User\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Records\Prescription\PrescriptAsset;
use App\Models\Records\Prescription\Prescription;
use App\Repositories\Emr\Prescription\PrescriptionRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AssetsController extends Controller
{


    protected $prescription;
    protected $prescriptionAssets;
    protected $response_type;
    protected $helpers;
    protected $uploads;
    protected $user;
    protected $userTransformer;
    protected $patient;

    public function __construct()
    {
        $this->prescription = new PrescriptionRepository(new Prescription());
        $this->prescriptionAssets = new PrescriptionRepository(new PrescriptAsset());
        $this->user = new UserRepository(new User());
        $this->patient = new PatientRepository(new Patient());
        $this->response_type = Config::get('response.http');
        $this->helpers = new HelperFunctions();
        $this->uploads = new Uploads();
        $this->userTransformer = new UserTransformer();
    }

    public function index(){}

    public function create(Request $request){

        $http_resp = $this->response_type['200'];
        $rules = [
            'prescription_for' => 'required|in:self,dependant',
            'patient_id' => 'required',
            'files' => 'required',
        ];
        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helpers->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        $prescription = null;

        DB::beginTransaction();

        try{

            $user_type = $this->user->getUserType($request->user());
            switch ($user_type){
                case 'Patient':
                    $patient = $this->patient->findPatientByUserId($request->user()->id);
                    $prescription = $this->patient->setPrescription($patient, $request->all());
                    break;
                case 'Doctor':

                    break;
            }

            //$prescription = $this->prescription->store($request->all());
            if ( $prescription ){
                $upload = $this->uploads->store_upload($request, $prescription);
                if (sizeof($upload)){
                    $asset = $this->prescriptionAssets->store_assets($prescription, $upload);
                }else{
                    //DB::rollBack();
                    $http_resp = $this->response_type['500'];
                    return response()->json($http_resp,500);
                }
            }else{
                //DB::rollBack();
                $http_resp = $this->response_type['500'];
                return response()->json($http_resp,500);
            }
        }catch (\Exception $e){

            Log::info($e);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);

        }
        DB::commit();
        return response()->json($http_resp);
    }
    public function update(Request $request, $uuid){}
    public function show($uuid){}
    public function delete($uuid){}

}

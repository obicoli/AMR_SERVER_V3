<?php

namespace App\Http\Controllers\Api\Consultation;

use App\helpers\HelperFunctions;
use App\Models\Consultation\Consultation;
use App\Models\Conversation\Groups;
use App\Models\Conversation\GroupUser;
use App\Models\Doctor\Doctor;
use App\Models\Patient\Patient;
use App\Models\Service\Service;
use App\Models\Users\User;
use App\Repositories\Consultation\ConsultationRepository;
use App\Repositories\Consultation\ConsultRepository;
use App\Repositories\Conversation\GroupRepository;
use App\Repositories\Doctor\DoctorRepository;
use App\Repositories\ModelRepository;
use App\Repositories\Patient\PatientRepository;
use App\Repositories\Services\Payment\PaymentRepositoty;
use App\Repositories\Services\Service\ServiceRepository;
use App\Repositories\User\UserRepository;
use App\Transformers\Consultation\ConsultationTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ConsultationController extends Controller
{
    //
    protected $consultation;
    protected $model;
    protected $http_response;
    protected $helper;
    protected $patient;
    protected $doctor;
    protected $user;
    protected $groups;
    protected $groupusers;


    public function __construct(Consultation $consultation)
    {
        $this->consultation = new ConsultRepository($consultation);
        $this->model = new ModelRepository($consultation);
        $this->user = new UserRepository(new User());
        $this->patient = new PatientRepository(new Patient());
        $this->doctor = new DoctorRepository(new Doctor());
        $this->groups = new GroupRepository(new Groups());
        $this->groupusers = new GroupRepository(new GroupUser());
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

//    public function __construct(Consultation $consultation, Patient $patient, Doctor $doctor,
//                                User $user, Service $service, Payment $payment)
//    {
//        $this->consultation = new ConsultationRepository($consultation);
//        $this->patient = new PatientRepository($patient);
//        $this->doctor = new DoctorRepository($doctor);
//        $this->user = new UserRepository($user);
//        $this->payment = new PaymentRepositoty($payment);
//        $this->service = new ServiceRepository($service);
//        $this->http_response = Config::get('response.http');
//        $this->helper = new HelperFunctions();
//        $this->transformer = new ConsultationTransformer();
//        $this->groups = new GroupRepository(new Groups());
//        $this->groupusers = new GroupRepository(new GroupUser());
//    }

    public function index(Request $request){
        Log::info($request);
        $http_resp = $this->http_response['200'];
        //$consults = $this->consultation->get()
        $user = $request->user();
        switch ( $this->user->getUserType($user) ){
            case Patient::USER_TYPE:
                $patient = $this->patient->findPatientByUserId($user->id);
                $consults = $this->consultation->get(null,$patient->id);
                $http_resp['results'] = $this->consultation->transform_collection($consults);
                break;
            case Doctor::USER_TYPE:
                $doctor = $this->doctor->findByUserId($user->id);
                break;
        }
        return response()->json($http_resp);
    }

    public function create(Request $request){

        $http_resp = $this->http_response['200'];
        Log::info($request);
        $inputs = [];
        $inputs_online = [];
        $inputs_offline = [];


        $user = $request->user();
        switch ($this->user->getUserType($user)){
            case Patient::USER_TYPE:

                $rules = [
                    'visit_type' => 'required|in:online,physical',
                    'who_is_patient' => 'required|in:self,dependant',
                    'doctor_preference' => 'required|in:any,specified',
                ];
                $msg = [];
                $validation = Validator::make($request->all(), $rules);
                if ($validation->fails()){
                    $http_resp = $this->http_response['422'];
                    $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                    return response()->json($http_resp,422);
                }

                if ($request->who_is_patient == "dependant"){
                    $rule2 = [
                        'dependant_id'=>'required'
                    ];
                    $validation = Validator::make($request->all(), $rule2);
                    if ($validation->fails()){
                        $http_resp = $this->http_response['422'];
                        $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                        return response()->json($http_resp,422);
                    }
                }else{
                    $inputs = $request->except(['dependant_id','service_data','offer_code','discount','patient_symptoms','time_band','date_fallen_sick']);
                }

                if ($request->doctor_preference == "specified"){
                    $rule2 = [
                        'doctor_id'=>'required'
                    ];
                    $validation = Validator::make($request->all(), $rule2);
                    if ($validation->fails()){
                        $http_resp = $this->http_response['422'];
                        $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                        return response()->json($http_resp,422);
                    }
                }else{
                    $inputs = $request->except(['doctor_id','service_data','offer_code','discount','patient_symptoms','time_band','date_fallen_sick']);
                }

                if ($request->doctor_preference == "any" && $request->who_is_patient == "self"){
                    $inputs = $request->except(['doctor_id','dependant_id','service_data','offer_code','discount','patient_symptoms','time_band','date_fallen_sick']);
                }

                if ($request->visit_type == "online"){
                    $inputs_online = $request->except(['doctor_id','dependant_id','service_data','offer_code','discount','patient_symptoms']);
                }
                $patient = $this->patient->findPatientByUserId($user->id);
                $inputs['patient_id'] = $patient->id;
                break;
            case Doctor::USER_TYPE:
                $doctor = $this->doctor->findByUserId($user->id);
                $inputs['doctor_id'] = $doctor->id;
                break;
        }

        DB::beginTransaction();
        try{
            $consult = $this->consultation->store($inputs);
            switch ($request->visit_type){
                case Consultation::VISIT_TYPE_ONLINE:
                    $consult->online()->create($inputs_online);
                    //consultation set groupable
                    $arr = [
                        'name'=>'Consult_'.$consult->id,
                        'created_by_user_id'=>$user->id,
                    ];

                    $group = $this->consultation->setChatGroup($consult, $arr);
                    //group current user in this newly created group
                    $group_user = [
                        'user_id' => $user->id,
                        'group_id' => $group->id,
                        'created_by_user_id'=>$user->id,
                        'updated_by_user_id'=>$user->id,
                    ];
                    $groupuser = $this->groupusers->setGroupUser($group_user);
                    break;
                case Consultation::VISIT_TYPE_OFFLINE:
                    $consult->offline()->create($inputs_offline);
                    break;
            }

        }catch (\Exception $e){
            Log::info($e);
            DB::rollBack();
            $http_resp = $this->http_response['500'];
            return response()->json($http_resp,500);
        }

        DB::commit();
        $http_resp['description'] = "Appointment successful created!";
        return response()->json($http_resp);

        //Log::info($request);
//        $http_resp = $this->http_response['200'];
//        DB::beginTransaction();
//        try{
//            //store consultation
//            $consult = $this->consultation->store($request->all());
//            //$this->consultation->setUid($consult, $this->helper->getToken(50));
//            $current_user = $this->user->findRecord($request->user()->id);
//            if ($this->user->isPatient($current_user)){
//                $this->consultation->setPatient($consult, $current_user->patient()->first());
//            }elseif($this->user->isDoctor($current_user)){
//                $this->consultation->setDoctor($consult, $current_user->doctor()->first());
//            }
//            //consultation set groupable
//            $arr = ['name'=>'Consult_'.$consult->id];
//            $group = $this->consultation->setChatGroup($consult, $arr);
//            //group current user in this newly created group
//            $group_user = [
//                'user_id' => $request->user()->id,
//                'group_id' => $group->id,
//            ];
//            $saved = $this->groupusers->setGroupUser($group_user);
//            //set consultation patient symptoms
//            if ( sizeof($request->patient_symptoms) ){
//                for ( $k = 0; $k < sizeof($request->patient_symptoms); $k++ ){
//                    $symptom = Symptom::find($request->patient_symptoms[$k]);
//                    $this->consultation->setSymptoms($consult,$symptom);
//                }
//            }
//            //set consultation date and time
//            $this->consultation->setTime($consult,$request->all());
//            $http_resp['results'] = $this->transformer->transform($consult);
//        }catch (\Exception $e){
//            Log::info($e);
//            DB::rollBack();
//            $http_resp['errors'] = ['Whoops! Something went wrong'];
//            return response()->json($http_resp,500);
//        }
//        DB::commit();
//        return response()->json($http_resp);
    }

    public function update(Request $request, $consultation_uid){
        //Log::info($request);
//        $http_resp = $this->http_response['200'];
//        $consult = $this->consultation->update($request->all(),$consultation_uid);
//        return response()->json($http_resp);
    }

    public function destroy($consultation_uid){

    }

    public function show(Request $request, $consultation_uuid){

        $http_resp = $this->http_response['200'];
        $consult = $this->consultation->findByUuid($consultation_uuid);
        $http_resp['results'] = $this->consultation->transform($consult, $request);
        return response()->json($http_resp);

//        $results = $this->transformer->transform($consult);
//        $user = $this->user->findRecord($request->user()->id);
//        if ($this->user->isPatient($user)){
//            //patient who booked this consultation
//            $results['is_patient'] = true;
//            $patient = $this->consultation->getPatient($consult); //this return an array
//            $patient['avatar'] = $this->user->getAvatar($user);//returns file path
//            $results['patient'] = $patient;
//            //possible doctor if is assigned to this consult
//            $results['doctor'] = $this->consultation->getDoctor($consult);//return an array;
//            //$results['doctor'] = $this->consultation->getDoctor($consult);
//            //$test_message = "Before we connect you with a provider, we'll need to perform a few final tests to ensure your computer can connect successfully.";
//            $room_wait_message = "Your doctor will enter when your consult starts at 8:40AM on Fri Aug 10.";
//        }else{
//            $doctor = $this->consultation->getDoctor($consult);
//            $doctor['avatar'] = $this->user->getAvatar($user);
//            $results['doctor'] = $doctor;
//            $results['patient'] = $this->consultation->getPatient($consult);
//            $results['is_doctor'] = true;
//            $room_wait_message = "Your patient will enter when your consult starts at 8:40AM on Fri Aug 10.";
//            //$test_message = "Before we connect you with a patient, we'll need to perform a few final tests to ensure your computer can connect successfully.";
//        }
//        $results['service_provider'] = $this->consultation->getProvider($consult);
//        $results['date_time'] = $this->consultation->getTime($consult);
//        //$results['test_message'] = $test_message;
//        $results['room_wait_message'] = $room_wait_message;
//        $http_resp['results'] = $results;
//        return response()->json($http_resp);
    }

//    public function payment_instruction(Request $request){
//
//    }

//    public function payment_confirmation(Request $request){
//
//        $http_resp = $this->http_response['200'];
//        $rule = [
//            'consultation_uuid' => 'required',
//            'mobile_paid' => 'required',
//            'transaction_code' => 'required',
//            'gateway' => 'required',
//        ];
//        $validate = Validator::make($request->all(),$rule);
//        if ($validate->fails()){
//            $http_resp = $this->http_response['422'];
//            $http_resp['errors'] = $this->helper->getValidationErrors($validate->errors());
//            return response()->json($http_resp, 422);
//        }
//        $consult = $this->consultation->findByUid($request->consultation_uuid);
//        $current_user = $this->user->findRecord($request->user()->id);
//        $confirmed_payment = $this->consultation->confirmPayment($consult, $request);
//        if ($confirmed_payment){
//            //set the consultation time
//            $this->consultation->setTime($consult,$request->all());
//            return response()->json($http_resp);
//        }else{
//            $http_resp = $this->http_response['422'];
//            $http_resp['errors'] = ['Payment confirmation failed'];
//            return response()->json($http_resp, 422);
//        }
//
//    }

//    public function pay(Request $request, $consult_uuid){
//
//        $consult = $this->consultation->findByUid($consult_uuid);
//        $http_resp = $this->http_response['200'];
//        $payments = $this->consultation->getPayment($consult);
//        if ($payments->count() > 0){
//            //payment record exists so check if this user is paid
//            $payment = false;
//            foreach ($payments as $paid){
//                if ($this->payment->findByUserId($request->user()->id)){
//                    $payment = $paid;
//                }
//            }
//            if (!$payment){
//                $this->consultation->setPayment($consult, $this->transformer->createPayment($request,$consult,$this->service->find($consult->service_id)));
//            }
//        }else{
//            $this->consultation->setPayment($consult, $this->transformer->createPayment($request,$consult,$this->service->find($consult->service_id)));
//        }
//        //return payment options and instruction
//        $http_resp['results'] = '';
//        return response()->json($http_resp);
//    }

//    public function get_consult_payment(Request $request, $consult_uuid){
//
//        $consult = $this->consultation->findByUid($consult_uuid);
//        $http_resp = $this->http_response['200'];
//        $payments = $this->consultation->getPayment($consult);
//        if ($payments->count() > 0){
//            //payment record exists so check if this user is paid
//            $payment = [];
//            foreach ($payments as $paid){
//                if ($this->payment->findByUserId($request->user()->id)){
//                    $payment['uuid'] = $paid->uuid;
//                    $payment['fees'] = $paid->fees;
//                    $payment['amount_paid'] = $paid->amount;
//                    $payment['account_number'] = $paid->account_number;
//                    $payment['gateway'] = $paid->gateway;
//                    $payment['transaction_code'] = $paid->txn_id;
//                    $payment['transaction_date'] = $paid->txn_date;
//                    $payment['status'] = $paid->status;
//                    $payment['mobile_phone'] = $paid->mobile_number_paid;
//                    $payment['currency'] = $paid->currency;
//                }
//            }
//        }else{
//            $payment = [];
//        }
//        //return payment options and instruction
//        $http_resp['results'] = $payment;
//        return response()->json($http_resp);
//    }

//    public function getByUser($uuid){
//
//        $http_resp = $this->http_response['200'];
//        $current_user = $this->user->findByUuid($uuid);
//        if ( $this->user->isDoctor($current_user) ){
//            $doctor = $this->doctor->findByUserId($current_user->id);
//            $consultations = $this->consultation->getByDoctor($doctor);
//        }else{
//            $patient = $this->patient->findPatientByUserId($current_user->id);
//            $consultations = $this->consultation->getByPatient($patient);
//        }
//
//        $response = [
//
//            'pagination' => [
//                'total' => $consultations->total(),
//                'per_page' => $consultations->perPage(),
//                'current_page' => $consultations->currentPage(),
//                'last_page' => $consultations->lastPage(),
//                'from' => $consultations->firstItem(),
//                'to' => $consultations->lastItem()
//            ],
//            'data' => $this->transformer->transformCollection($consultations)
//        ];
//        $http_resp['results'] = $response;
//
//        return response()->json($http_resp);
//
//    }

//    public function doctor_signature(Request $request){
//
//        $http_resp = $this->http_response['422'];
//        $rule = [
//            'signature' => 'required',
//            'user_uuid' => 'required',
//            'consult_id' => 'required',
//        ];
//        $validator = Validator::make($request->all(), $rule);
//        if ($validator->fails()){
//            $http_resp = $this->http_response['422'];
//            $http_resp['errors'] = $this->helper->getValidationErrors($validator->errors());
//            return response()->json($http_resp, 422);
//        }
//
//        $user = $this->user->findRecord($request->user()->id);
//        $consult = $this->consultation->findByUid($request->consult_id);
//
//        $sign = $request->signature;
//        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i','',$sign));
//        $sign_name = str_random(10).'.'.'png';
//        if ( !file_exists( $_SERVER['DOCUMENT_ROOT'].'/img/signatures/sign_'.$user->id ) ){
//            mkdir($_SERVER['DOCUMENT_ROOT'].'/img/signatures/sign_'.$user->id, 0777, true);
//        }
//
//        if ( File::put( $_SERVER['DOCUMENT_ROOT'].'/img/signatures/sign_'.$user->id.'/'.$sign_name, $data ) ){
//            $this->consultation->setSignature($consult,'/img/signatures/sign_'.$user->id.'/'.$sign_name);
//        }
//
//        return response()->json($http_resp);
//
//    }

}

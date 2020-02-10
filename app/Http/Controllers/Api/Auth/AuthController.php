<?php

namespace App\Http\Controllers\Api\Auth;

use App\helpers\HelperFunctions;
use App\Models\Application\Settings;
use App\Models\Doctor\Education;
use App\Models\Doctor\MedicalRegistration;
use App\Models\Pharmacy\Pharmacy;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeUser;
use App\Models\Users\Activation;
use App\Models\Users\Assets;
//use App\Models\Users\Doctor;
//use App\Models\Users\Patient;
use App\Models\Doctor\Doctor;
use App\Models\Patient\Patient;
use App\Models\Users\User;
use App\Repositories\Doctor\DoctorRepository;
use App\Repositories\Patient\PatientRepository;
//use App\Repositories\User\ActivationRepository;
use App\Repositories\Pharmacy\PharmacyRepository;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\User\UserRepository;
use App\Traits\ActivationTrait;
use App\Transformers\User\DoctorTransformer;
use App\Transformers\User\PatientTransformer;
use App\Transformers\User\UserTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mobile\Repository\MobileRepository;
use App\Models\Module\Module;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use jeremykenedy\LaravelRoles\Models\Role;

class AuthController extends Controller
{
    //
    use ActivationTrait;
    protected $user;
    protected $doctor;
    protected $pharmacy;
    protected $patient;
    protected $practice;
    protected $practiceUser;
    protected $response_type;
    protected $transformer;
    protected $helpers;
    protected $mobileApp;

    public function __construct(User $user)
    {
        $this->user = new UserRepository($user);
        $this->doctor = new DoctorRepository(new Doctor());
        $this->patient = new PatientRepository(new Patient());
        $this->pharmacy = new PharmacyRepository(new Pharmacy());
        $this->response_type = Config::get('response.http');
        $this->transformer = new UserTransformer();
        $this->helpers = new HelperFunctions();
        $this->practice = new PracticeRepository(new Practice());
        $this->practiceUser = new PracticeRepository(new PracticeUser());
        $this->mobileApp = new MobileRepository( new User() );
    }

    public function validatedToken(Request $request){
        $http_resp = $this->response_type['200'];
        Log::info($request);
        return response()->json($http_resp);
    }

    public function changepassword(Request $request){

        $http_resp = $this->response_type['200'];
        $rule = [
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ];

        $validation = Validator::make($request->all(), $rule);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helpers->getValidationErrors($validation->errors());
            return response()->json($http_resp, 422);
        }

        $user = $this->user->findRecord($request->user()->id);
        if( Hash::check($request->old_password, $request->user()->password ) ){
        }else{
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = ['The old password is incorrect'];
            return response()->json($http_resp, 422);
        }

        if($request->old_password == $request->password){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = ['Please choose a new password to continue!'];
            return response()->json($http_resp, 422);
        }

        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try{

            $practice = $this->practice->find($request->user()->company_id);
            $practiceUser = $this->practiceUser->findByUserIdPracticeId($user->id,$practice->id,$user->email);
            $new_hashed_password = $this->user->createPassword($request->password);
            $updates['status'] = "Active";
            $updates['password'] = $new_hashed_password;
            $this->practiceUser->update($updates,$practiceUser->uuid);
            $user->password = $new_hashed_password;
            $user->save();
            $http_resp['description'] = "Password successful changed!";

        }catch(\Exception $e){
            $http_resp = $this->response_type['500'];
            Log::info($e);
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            return response()->json($http_resp, 500);
        }
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function register(Request $request){

        $http_resp = $this->response_type['200'];
        $validation = Validator::make($request->all(),$this->transformer->signupRule());
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helpers->getValidationErrors($validation->errors());
            return response()->json($http_resp, 422);
        }

        $encoded_mobile = $this->helpers->encode_mobile($request->mobile);
        if (!$encoded_mobile){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = ['Invalid or missing mobile number!'];
            return response()->json($http_resp, 422);
        }

        if (!$this->helpers->isPastDate($request->date_of_birth)){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = ['Date of birth must be a past date'];
            return response()->json($http_resp, 422);
        }

        if ($request->user_type == "doctor" && $request->registration_number == ""){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = ['Doctor registration number required!'];
            return response()->json($http_resp, 422);
        }

        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try {
            Log::info($request);
            //Hash user password
            $inputs = $request->all();
            $inputs['password'] = Hash::make($request->password);
            $inputs['mobile'] = $encoded_mobile;
            $user = $this->user->createProfile($inputs);
            //intiate OTP
            $token = $this->helpers->getCode(5);
            $otp['token'] = $token;
            $sms = "Your one-time password is ".$token." valid until 24 hours. Please key in to complete your registration.";
            $this->initiateOtp($user, $otp);
            $this->initiateSms($encoded_mobile, $sms);
            $http_resp['description'] = 'We have sent a verification code to '.$encoded_mobile;
            //send verification email
            $this->initiateVerification($user);
        }catch (\Exception $e){
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            Log::info($e);
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp, 500);
        }
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        //return 200 http response
        return response()->json($http_resp, 200);
    }

    public function mobile_login(Request $request){
        //This is a function to login mobile app users
        $http_resp = $this->response_type['200'];
        $login_rule = [
            'email' => 'required',
            'password' => 'required',
        ];
        $source_type = "app";
        $validation = Validator::make($request->all(),$login_rule);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helpers->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        $user = $this->user->findByEmailOrMobile($request->email);
        $companyUser = null;
        $accounts = null;
        $account_found = false;
        //Log::info($user);
        if ( $user && Hash::check($request->password, $user->password) ){
            $practiceUsers = $this->practiceUser->getByEmail($user->email);
            $company = $this->practice->find($user->company_id);
            $account_found = true;
            $accounts = $this->mobileApp->transformUser($user);
        }
        //--
        if ( $account_found ){
            $http_resp = $this->response_type['200'];
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            if ($request->remember_me){
                $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();
            }
            $http_resp['access_token'] = $tokenResult->accessToken;
            $http_resp['token_type'] = 'Bearer';
            $http_resp['expires_at'] = Carbon::parse($tokenResult->token->expires_at)->toDateTimeString();
            $http_resp['results'] = $accounts;
            return response()->json($http_resp);
        }else{
            $http_resp = $this->response_type['400'];
            return response()->json($http_resp, 400);
        }
    }

    public function login(Request $request){

        $http_resp = $this->response_type['200'];
        $login_rule = [
            'email' => 'required',
            'password' => 'required',
        ];
        $source_type = "web";
        //Log::info($source_type);
        $validation = Validator::make($request->all(),$login_rule);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helpers->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        $accounts = array();
        $account_found = false;
        $user = $this->user->findByEmailOrMobile($request->email);
        if ( $user && Hash::check($request->password, $user->password) ){
            $account_type = $this->user->getUserType($user);
            $account_found = true;
            for ( $k=0; $k < sizeof($account_type); $k++ ){
                switch ($account_type[$k]){
                    case Patient::USER_TYPE:
                        $acca['account_type'] = Patient::USER_TYPE;
                        $acca['data'] = $this->patient->transform_profile($this->patient->findPatientByUserId($user->id),'basic');
                        array_push($accounts,$acca);
                        break;
                    case Pharmacy::USER_TYPE:
                        //$pharmacyRepo = new PharmacyRepository(new Pharmacy());
                        $pharmacy = $this->pharmacy->findByUserId($user->id);
                        $acca['account_type'] = Pharmacy::USER_TYPE;
                        $acca['data'] = $this->pharmacy->transform($pharmacy);
                        array_push($accounts,$acca);
                        break;
                    case Doctor::USER_TYPE:
                        //$doctorRepo = new DoctorRepository(new Doctor());
                        $acca['account_type'] = Doctor::USER_TYPE;
                        $acca['data'] = $this->doctor->transform_($this->doctor->findByUserId($user->id));
                        array_push($accounts,$acca);
                        break;
                }
            }
        }

        $companyUser = null;

        if ($user){
            $practiceUsers = $this->practiceUser->getByEmail($user->email);
            $company = $this->practice->find($user->company_id);
            foreach ($practiceUsers as $practiceUser){
                if ( Hash::check($request->password, $practiceUser->password) ){
                    $account_found = true;
                    $acca['account_type'] = PracticeUser::USER_TYPE;
                    $acca['data'] = $this->practice->transform_user($practiceUser,$source_type,$company);
                    array_push($accounts,$acca);
                    $companyUser = $practiceUser;
                }
            }
        }

        if ( $account_found ){
            $http_resp = $this->response_type['200'];
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            if ($request->remember_me){
                $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();
            }
            $http_resp['access_token'] = $tokenResult->accessToken;
            $http_resp['token_type'] = 'Bearer';
            $http_resp['expires_at'] = Carbon::parse($tokenResult->token->expires_at)->toDateTimeString();
            $http_resp['results'] = $accounts;
            return response()->json($http_resp);

        }else{
            $http_resp = $this->response_type['400'];
            return response()->json($http_resp, 400);
        }

    }

    public function invitation(Request $request){
        $http_resp = $this->response_type['200'];
        $login_rule = [
            'user_uuid' => 'required',
            'practice_id' => 'required',
            'password' => 'required|min:8|confirmed',
            'email' => 'required',
        ];
        $validation = Validator::make($request->all(),$login_rule);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helpers->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try{

            $user = $this->user->findByUuid($request->user_uuid);
            $practice = $this->practice->findByUuid($request->practice_id);
            $practiceUser = $this->practiceUser->findByUserIdPracticeId($user->id,$practice->id,$user->email);
            $new_hashed_password = $this->user->createPassword($request->password);
            $updates['status'] = "Active";
            $updates['password'] = $new_hashed_password;
            $this->practiceUser->update($updates,$practiceUser->uuid);
            $user->password = $new_hashed_password;
            $user->save();
            $practiceUser = $this->practiceUser->findByUserIdPracticeId($user->id,$practice->id,$user->email);

            // if ($user && Hash::check($request->password, $practiceUser->password) ){
            //     if ($this->user->activated($user)){
            //         $http_resp = $this->response_type['200'];
            //         $tokenResult = $user->createToken('Personal Access Token');
            //         $token = $tokenResult->token;
            //         if ($request->remember_me){
            //             $token->expires_at = Carbon::now()->addWeeks(1);
            //             $token->save();
            //         }
            //         $http_resp['access_token'] = $tokenResult->accessToken;
            //         $http_resp['token_type'] = 'Bearer';
            //         $http_resp['expires_at'] = Carbon::parse($tokenResult->token->expires_at)->toDateTimeString();
            //         //$http_resp['results'] = $this->transformer->transform($user);
            //         $http_resp['results'] = $this->user->getAccounts($user);
            //         return response()->json($http_resp);
    
            //     }else{
            //         $http_resp = $this->response_type['402'];
            //         return response()->json($http_resp, 402);
            //     }
            // }
            // $http_resp = $this->response_type['400'];
            // return response()->json($http_resp, 400);
        }catch(\Exception $e){
            Log::info($e);
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp, 500);
        }
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        return response()->json($http_resp);

    }

    public function show($uuid,$practice_uuid){

        $http_resp = $this->response_type['200'];
        $practice = $this->practice->findByUuid($practice_uuid);
        $user = $this->user->findByUuid($uuid);
        $practiceUser = $this->practiceUser->findByUserIdPracticeId($user->id,$practice->id,$user->email);
        if ($practiceUser && $practiceUser->status=="Active"){
            $http_resp = $this->response_type['401'];
            $http_resp['description'] = 'Expired Link';
            return response()->json($http_resp,401);
        }elseif($practiceUser && $practiceUser->status=="Invited"){
            $http_resp['results'] = $user;
            return response()->json($http_resp);
        }else{
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }


    }

    public function privilege(Request $request){

        $http_resp = $this->response_type['200'];
        $login_rule = [
            'action_type' => 'required',
            'token' => 'required',
        ];
        $validation = Validator::make($request->all(),$login_rule);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helpers->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{
            $activation = Activation::all()->where('token',$request->token)->first();
            if ($activation){
                $practice = $this->practice->findByUuid($activation->owner_type);
                $master_practice = $this->practice->findOwner($practice);
                $master_admin = $this->practice->findMasterAdmin($master_practice);
                $user = $this->user->findRecord($activation->owner_id);
                $master_user = $this->user->findRecord($master_admin->user_id);
                $practiceUser = $this->practiceUser->findByUserIdPracticeId($user->id,$practice->id,$user->email);
                $mail_data = $practice->toArray();
                $descr = "";
                switch ($request->action_type){
                    case "decline":
                        $descr = "You have declined master account administrator privileges for ".$practice->name.". An e-mail has been sent to the current master account administrator explaining that you have declined these privileges.";
                        $mail_data['custom_message'] = "You recently requested that the Master Administrator role for the facility called ".$practice->name." be transferred to ".$practiceUser->first_name.". When we notified ".$practiceUser->first_name." of your request, they declined to accept the Master Administrator role.";
                        $mail_data['custom_message_2'] = "As a result, you are still the Master Administrator of the facility called ".$practice->name.".";
                        break;
                    case "accept":
                        //exchange role
                        $practice_master_admin = $this->practiceUser->findByUserIdPracticeId($master_user->id,$practice->id,$master_user->email);
                        $master_role = Role::all()->where('slug','master.admin')->first();
                        $admin_role = Role::all()->where('slug','admin')->first();
                        $this->practiceUser->detachRole($practice_master_admin,$master_role);
                        $this->practiceUser->attachRole($practice_master_admin,$admin_role);
                        $this->practiceUser->attachRole($practiceUser,$master_role);
                        $descr = "Master account administrator privileges for facility ".$practice->name." have been successfully transferred to you. An e-mail has been sent to the former master account administrator confirming the transfer.";
                        $mail_data['custom_message'] = "This email is to inform you that you have successfully transferred master account administrator privileges for ".$practice->name." to ".$practiceUser->first_name.".";
                        $mail_data['custom_message_2'] = "This means that ".$practiceUser->first_name.
                            " has taken over your role as Master Administrator, making you a Facility Administrator for ".$practice->name.
                            ". As a Facility Administrator, you maintain the same set of rights as the Master Administrator, except that you will no longer receive email notifications regarding account-related actions or requests.";
                        break;
                }
                $mail_data['send_to'] = $master_admin->first_name;
                $mail_data['practice_name'] = $practice->name;
                $this->initiateMails($master_user, Settings::MASTER_FACILITY_ADMIN,$mail_data);
                $activation->delete();
                $http_resp['description'] = $descr;
            }else{
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = ['Expired link!'];
                return response()->json($http_resp,422);
            }

        }catch (\Exception $exception){
            DB::rollBack();
            Log::info($exception);
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp, 500);
        }

        DB::commit();
        //return 200 http response
        return response()->json($http_resp, 200);

    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json($this->response_type['200']);
    }

}

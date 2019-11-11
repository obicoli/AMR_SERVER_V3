<?php

namespace App\Http\Controllers\Api\Auth;

use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Models\Users\Activation;
use App\Models\Users\User;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\User\UserRepository;
use App\Traits\ActivationTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ActivationController extends Controller
{
    use ActivationTrait;
    protected $user;
    protected $response_type;
    protected $activation;
    protected $helper;
    protected $practice;

    public function __construct()
    {
        $this->user = new UserRepository(new User());
        $this->practice = new PracticeRepository(new Practice());
        $this->response_type = Config::get('response.http');
        $this->activation = new UserRepository(new Activation());
        $this->helper = new HelperFunctions();
    }

    public function resendLink($email){

        $http_resp = $this->response_type['200'];

        $lost_user = $this->user->findByEmail($email);
        if (!$lost_user){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = [trans('auth.noAccountTrace')];
            return response()->json($http_resp,422);
        }
        //
        if ($this->user->activated($lost_user)){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = [trans('auth.alreadyActivated')];
            return response()->json($http_resp,422);
        }

        $activationsCount = Activation::where('user_id', $lost_user->id)
            ->where('created_at', '>=', Carbon::now()->subHours(config('settings.timePeriod')))
            ->count();

        if ($activationsCount >= config('settings.maxAttempts')) {
            Log::info('Exceded max resends in last '.config('settings.timePeriod').' hours. ', [$lost_user]);
            $message = "Too many password reset emails have been sent to ".$lost_user->email." Please try again in ".config('settings.timePeriod').' Hrs';
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = [$message];
            return response()->json($http_resp,422);
        }
        $this->initiateVerification($lost_user);
        $http_resp['description'] = trans('auth.activationSent');
        return response()->json($http_resp);

    }

    public function reset(Request $request){
        $http_resp = $this->response_type['200'];
        $rule = [
            'email'=>'required|email'
        ];
        $validation = Validator::make($request->all(),$rule);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        $lost_user = $this->user->findByEmail($request->email);
        if (!$lost_user){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = [trans('auth.noAccountTrace')];
            return response()->json($http_resp,422);
        }

        $this->initiatePasswordReset($lost_user);
        $http_resp['description'] = trans('auth.activationSent');
        return response()->json($http_resp);

    }

    public function create(Request $request){
        $http_resp = $this->response_type['200'];
        $rule = [
            'token'=>'required',
            'password'=>'required|confirmed|min:8',
        ];

        $validation = Validator::make($request->all(),$rule);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        //$activation = $this->activation->findByToken($request->token);
        $activationsCount = Activation::where('token', $request->token)
            ->where('created_at', '>=', Carbon::now()->subHours(config('settings.timePeriod')))
            ->get()->first();
        if (!$activationsCount){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = [trans('auth.invalidToken')];
            return response()->json($http_resp,422);
        }
        DB::beginTransaction();
        try{
            $lost_user = $this->user->findRecord($activationsCount->owner_id);
            $this->user->setPassword($lost_user,$request->all());
            //$this->activation->deleteByUserId($lost_user->id);
            $this->deleteTokens($lost_user);
        }catch (\Exception $exception){
            Log::info($exception);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        $http_resp['description'] = 'New password successful created!';
        return response()->json($http_resp);
    }

    public function create_password(Request $request, $uuid){
        $http_resp = $this->response_type['200'];
        $rule = [
            'password'=>'required|confirmed|min:8',
        ];
        $validation = Validator::make($request->all(),$rule);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        $activation = $this->user->findByUuid($uuid);
        if (!$activation){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = ['Account not found'];
            return response()->json($http_resp,422);
        }

        $this->user->setPassword($activation, $request->all());
        return response()->json($http_resp,200);


    }

    public function activate($token){

        $http_resp = $this->response_type['200'];

        try{

            $activationsCount = Activation::where('token', $token)
                ->where('created_at', '>=', Carbon::now()->subHours(config('settings.timePeriod')))
                ->get()->first();
            if ($activationsCount){

                switch ($activationsCount->owner_type){
                    case "App\Models\Practice\Practice": //practice mobile activation
                        $result['activation_type'] = 'Email';
                        $result['activation_module'] = 'Practice';
                        $result['mail_activation_required'] = false;
                        $result['mobile_activation_required'] = false;
                        $activation_practice = $this->practice->find($activationsCount->owner_id);
                        $this->practice->verify_email($activation_practice);
                        $result['uuid'] = $activation_practice->uuid;
                        $result['name'] = $activation_practice->name;
                        $activationsCount->delete();
                        $http_resp['results'] = $result;
                        break;
                    case "App\Models\Users\User":
                        $result['activation_type'] = 'Email';
                        $result['activation_module'] = 'User';
                        $result['mail_activation_required'] = false;
                        $result['mobile_activation_required'] = false;
                        $user = $this->user->findRecord($activationsCount->owner_id);
                        $user->email_verified = true;
                        $user->status = 'Activated';
                        $user->save();
                        $this->deleteTokens($user);
                        $http_resp['results'] = $result;
                        break;
                }

            }else{

                DB::rollBack();
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = [trans('auth.invalidToken')];
                return response()->json($http_resp,422);

            }

        }catch (\Exception $e){
            Log::info($e);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp, 500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function getUser($uuid){

        $http_resp = $this->response_type['200'];
        $user_data = $this->user->findByUuid($uuid);
        if ($user_data){
            $results['email'] = $user_data->email;
            $results['password'] = $user_data->password;
            $http_resp['results'] = $results;
            return response()->json($http_resp,200);
        }else{
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = 'Account not found';
            return response()->json($http_resp,422);
        }
    }

    public function verifyOtp(Request $request){

        $http_resp = $this->response_type['200'];
        $rule = [
            //'mobile'=>'required',
            'verification_code'=>'required',
        ];
        $validator = Validator::make($request->all(),$rule);
        if ($validator->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validator->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{

            $activationsCount = Activation::where('token', $request->verification_code)
                ->where('created_at', '>=', Carbon::now()->subHours(config('settings.timePeriod')))
                ->get()->first();
            if ($activationsCount){

                switch ($activationsCount->owner_type){

                    case Practice::NAME_SPACE: //practice mobile activation
//                        $result['activation_type'] = 'Otp';
//                        $result['activation_type'] = 'Practice';
//                        $result['mail_activation_required'] = false;
//                        $result['mobile_activation_required'] = false;
                        $activation_practice = $this->practice->find($activationsCount->owner_id);
                        $this->practice->verify_mobile($activation_practice);
                        $activationsCount->delete();
                        $http_resp['results'] = $this->practice->transform_($activation_practice);
                        $http_resp['description'] = "Mobile verification was successful!";

//                        if (!$activation_practice->mail_verified){
//                            $result['mail_activation_required'] = true;
//                            $token = $this->helper->getToken(50);
//                            $other_data['token'] = $token;
//                            $this->initiateOtp($activation_practice, $other_data);
//                            $other_data['uuid'] = $activation_practice->uuid;
//                            $other_data['name'] = $activation_practice->name;
//                            $other_data['first_name'] = $activation_practice->name;
//                            $this->initiatePracticeEmail($activation_practice,false,Practice::AC_VERIFICATION,$other_data);
//                        }

//                        $result['uuid'] = $activation_practice->uuid;
//                        $result['name'] = $activation_practice->name;
//                        $http_resp['results'] = $result;
                        break;
                    case "App\Models\Users\User":
                        $user = $this->user->findRecord($activationsCount->owner_id);
                        $user->mobile_verified = true;
                        $user->save();
                        $this->deleteTokens($user);
                        $this->initiateVerification($user);
                        $http_resp['description'] = "We have an email verification link to ".$user->email;
                        break;
                }

            }else{
                DB::rollBack();
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = ['Invalid or missing verification code!'];
                return response()->json($http_resp,422);
            }

        }catch (\Exception $e){
            Log::info($e);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp, 500);
        }

        DB::commit();
        return response()->json($http_resp);
    }

    public function resendOtp(Request $request){

        $http_resp = $this->response_type['200'];

        $rule = [
            'activation_type'=>'required|in:Practice,Doctor,Patient,User',
            'mobile'=>'required',
        ];
        $validation = Validator::make($request->all(), $rule);

        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        $encoded_mobile = $this->helper->encode_mobile($request->mobile);
        if (!$encoded_mobile){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = ['Invalid or missing mobile!'];
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{
            switch ($request->activation_type){
                case 'User':

                    $user = $this->user->findByEmailOrMobile($encoded_mobile);

                    if ($this->countOtpResend($encoded_mobile) > config('settings.otpResendTrial')){
                        $http_resp = $this->response_type['422'];
                        $http_resp['errors'] = ['Maximum OTP resend attempts reached. Please try again later'];
                        return response()->json($http_resp,422);
                    }

                    $otp_code = $this->helper->getCode(4);
                    $otp['token'] = $otp_code;
                    $sms = "Your one-time password is ".$otp_code." valid until 24 hours. Please key in to complete your registration.";
                    $this->initiateOtp($user, $otp);
                    $this->initiateSms($encoded_mobile, $sms);
                    $http_resp['description'] = "We have sent a verification code to ".$encoded_mobile;

                    break;
                case 'Practice':

                    $practice = $this->practice->findByMobile($encoded_mobile);
                    //initiate an otp
                    $otp_code = $this->helper->getCode(4);
                    $otp['token'] = $otp_code;
                    $sms = "Your one-time password is ".$otp_code." valid until 24 hours. Please key in to complete your ".$practice->name." registration.";
                    //$this->practice->create_activation($practice, $otp);
                    $this->initiateOtp($practice, $otp);
                    $this->initiateSms($encoded_mobile, $sms);
                    $http_resp['description'] = "We have sent a verification code to ".$encoded_mobile;

                    break;
            }

        }catch (\Exception $e){
            Log::info($e);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp, 500);
        }

        DB::commit();
        return response()->json($http_resp);
    }

}

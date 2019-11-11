<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/26/18
 * Time: 11:21 AM
 */

namespace App\Traits;


use App\Mail\MailEngine;
use App\Mail\PracticeMail;
use App\Models\Practice\Practice;
use App\Models\Users\Activation;
use App\Models\Users\User;
use App\helpers\HelperFunctions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

trait ActivationTrait
{

    public function initiateOtp(Model $model, array $arr){
        // TODO: Implement create_activation() method.
        return $model->activation()->create($arr);
    }

    public function deleteTokens(Model $model){
        $model->activation()->delete();
    }

    public function countOtpResend($mobile){
        return Activation::all()->where('mobile',$mobile)->count();
    }

    public function initiateVerification(User $user){
        return $this->createTokenAndSendMail($user,'Email Verification');
    }

    public function initiatePracticeUserInvitation(User $user, Practice $practice, $other_data = array()){
        return $this->inviteUser($user, $practice,$other_data);
    }

    public function initiateMails(User $user, $subject, array $mail_data){
        return $this->sendMails($user, $subject, $mail_data);
    }

    public function initiatePasswordReset(User $user){
        return $this->createTokenAndSendMail($user,'Password Reset');
    }

    public function initiateSms($mobile, $message, $country_code = 'KE'){
        $encoded_mobile = $this->encode_mobile($mobile, $country_code);
        if ($encoded_mobile){
            $sdp_output = $this->sendSms($encoded_mobile, $message);
            if ($sdp_output){
                return 'send';
            }
            return "Something went wrong. Try again later";
        }else{
            return "Invalid mobile number";
        }
    }

    public function initiatePracticeEmail(Practice $practice, $model = false, $subject, $other_data = array()){
        Mail::to($practice)->send( new PracticeMail($practice, false, $subject, $other_data));
    }

    protected function createTokenAndSendMail(User $user,$subject){
        $helper = new HelperFunctions();
        $token = $helper->getToken(50);
        $activation = new Activation();
        $activation->token = $token;
        $user->activation()->save($activation);
        Mail::to($user)->send( new MailEngine($user, $subject));
        return true;
    }

    protected function inviteUser(User $user, Practice $practice, $other_data = array()){
        $activation = new Activation();
        $activation->token = $practice->uuid;//
        $user->activation()->save($activation); //
        Mail::to($user)->send( new MailEngine($user, 'Invitation', $other_data)); //
        return true;
    }

    protected function sendMails(User $user, $subject, array $mail_data){
        Mail::to($user)->send( new MailEngine($user, $subject, $mail_data));
        return true;
    }

    protected function encode_mobile($mobile, $country_code='KE'){
        $swissNumberStr = $mobile;
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        try{
            $swissNumberProto = $phoneUtil->parse($swissNumberStr, $country_code);
            if ($phoneUtil->isValidNumber($swissNumberProto)) {
                # code...
                $phone = $phoneUtil->format($swissNumberProto, \libphonenumber\PhoneNumberFormat::E164);
                return str_replace("+","",$phone);
            }else{
                return false;
            }
        } catch (\libphonenumber\NumberParseException $e) {
            return false;
        }
    }

    protected function sendSms($mobile,$message){
        $u_name = "webulk";
        $p_word = "1@webulx2017";
        $url = "http://41.72.223.200/sms/fxd1.php";
        //$url = "http://192.168.1.151/sms/fxd1.php";
        $fields = 'usr='.$u_name.'&pass='.$p_word.'&dest='.$mobile.'&msg='.$message.'&mode=json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $sdp_output = curl_exec ($ch);
        //Log::info($sdp_output);
        return $sdp_output;
    }

}

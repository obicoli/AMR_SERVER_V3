<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/14/18
 * Time: 6:42 PM
 */

namespace App\Transformers\User;

use App\helpers\HelperFunctions;
use App\Models\Pharmacy\Pharmacy;
use App\Models\Practice\Practice;
use App\Models\Users\Assets;
use App\Models\Doctor\Doctor;
use App\Models\Patient\Patient;
use App\Models\Users\User;
use App\Repositories\Doctor\DoctorRepository;
use App\Repositories\Patient\PatientRepository;
use App\Repositories\Pharmacy\PharmacyRepository;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\User\AssetRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use jeremykenedy\LaravelRoles\Models\Role;


class UserTransformer
{
    public function transformCollection($collections){

        $results = array();

        $helper = new HelperFunctions();

        foreach ($collections as $collection){
            $temp_data['id'] = $collection->uuid;
            $temp_data['name'] = $collection->username;
            $temp_data['full_name'] = $this->getUserFullname($collection);
            $temp_data['mobile'] = $collection->mobile;
            $temp_data['email'] = $collection->email;
            $temp_data['status'] = $collection->status;
            $temp_data['type'] = $this->getUserRole($collection);
            $temp_data['registration_number'] = 'REG1';
            $temp_data['created_at'] = $helper->format_mysql_date($collection->created_at);
            array_push($results, $temp_data);
        }
        return $results;
    }

    public function owner_type(User $user){

        if ($user->hasRole('patient')){}
    }

    public function signupRule(){
        return [
            'first_name' => 'required',
            'other_name' => 'required',
            'date_of_birth' => 'required',
            'country' => 'required',
            'gender' => 'required',
            'city' => 'required',
            'user_type' => 'required|in:doctor,patient',
            'email' => 'required|email|unique:users|unique:patients|unique:doctors',
            //'username' => 'required|unique:users',
            'mobile' => 'required|unique:users|unique:patients|unique:doctors',
            'password' => 'required|confirmed|min:8',
        ];
    }


//    public function transformPracticeUsers($collections, $practice_uuid){
//
//        $results = array();
//
//        $helper = new HelperFunctions();
//        $docy = new DoctorRepository(new Doctor());
//        $user = new UserRepository(new User());
//
//        foreach ($collections as $collection){
//
//            $access_type = $this->getPracticeUserRole($collection, $practice_uuid);
//            $user_data = $user->findRecord($collection->user_id);
//            if ($access_type == 'Owner' || $access_type == 'Doctor'){
//                $doctor = $docy->findByUserId($collection->user_id);
//                $temp_data['id'] = $doctor->uuid;
//                $temp_data['name'] = $user_data->username;
//                $temp_data['full_name'] = $doctor->first_name.' '.$doctor->last_name;
//                $temp_data['mobile'] = $user_data->mobile;
//                $temp_data['uuid'] = $user_data->uuid;
//                $temp_data['email'] = $user_data->email;
//                $temp_data['status'] = $user_data->status;
//                $temp_data['registration_number'] = $doctor->registration_number;
//            }else{
//
//            }
//
//            $temp_data['type'] = $access_type;
//            array_push($results, $temp_data);
//        }
//        return $results;
//    }

//    public function transformPracticePatients($collections, $practice_uuid){
//
//        $results = array();
//
//        $helper = new HelperFunctions();
//        $patient = new PatientRepository(new Patient());
//        $user = new UserRepository(new User());
//
//        foreach ($collections as $collection){
//
//            $access_type = $this->getPracticeUserRole($collection, $practice_uuid);
//            $user_data = $user->findRecord($collection->user_id);
//            if ($access_type == 'Patient'){
//                $patie = $patient->findPatientByUserId($user_data->id);
//                $temp_data['id'] = $patie->id;
//                $temp_data['uuid'] = $patie->uuid;
//                $temp_data['name'] = $user_data->username;
//                $temp_data['full_name'] = $patie->first_name.' '.$patie->last_name;
//                $temp_data['mobile'] = $user_data->mobile;
//                $temp_data['email'] = $user_data->email;
//                $temp_data['patient_number'] = 'P'.$patie->id;
//                $temp_data['type'] = $access_type;
//                array_push($results, $temp_data);
//            }
//
//        }
//        return $results;
//    }

//    public function transformPracticePatient(User $user, Practice $practice, Patient $patient){
//
//        $helper = new HelperFunctions();
//        $results = array();
//        $results['first_name'] = $patient->first_name;
//        $results['last_name'] = $patient->last_name;
//        $results['uuid'] = $patient->uuid;
//        $results['age'] = $helper->calculateAge($patient->dob);
//        $results['gender'] = $patient->gender;
//        $results['patient_number'] = $patient->patient_number;
//        $results['blood_group'] = $patient->blood_group;
//        $results['mobile'] = $user->mobile;
//        $results['email'] = $user->email;
//        return $results;
//
//    }

//    public function getPracticeUserRole(PracticeUsers $practiceUsers, $practice_uuid){
//
//        $practiceRepo = new PracticeRepository(new Practice());
//        $practice = $practiceRepo->findByUuid($practice_uuid);
//        if ($practice->created_by_user_id == $practiceUsers->user_id){
//            return 'Owner';
//        }
//
//        if ($practiceUsers->hasRole('doctor')){
//            return 'Doctor';
//        }elseif ( $practiceUsers->hasRole('receptionist') ){
//            return 'Receptionist';
//        }elseif ( $practiceUsers->hasRole('patient') ){
//            return 'Patient';
//        }
//
//    }


    public function transform(User $user){

        $results = array();
        //$results['id'] = $user->uuid;
        $results['email'] = $user->email;
        $results['mobile'] = $user->mobile;
        $results['user_type'] = '';
        $results['dashboard_url'] = '';
        $results['first_name'] = '';
        $results['other_name'] = '';
        $results['account_status'] = $user->status;
        $userRepo = new UserRepository(new User());
        $app_settings = Config::get('settings.application');
        if ($userRepo->activated($user)){

            $assetRepo = new AssetRepository(new Assets());

            switch ($userRepo->getUserType($user)){
                case Patient::USER_TYPE:
                    $patientRepo = new PatientRepository(new Patient());
                    $patient = $patientRepo->findPatientByUserId($user->id);
                    $results['id'] = $patient->uuid;
                    $results['dashboard_url'] = $app_settings['patient_domain'];
                    $results['user_type'] = Patient::USER_TYPE;
                    $results['first_name'] = $patient->first_name;
                    $results['other_name'] = $patient->other_name;
                    $results['avatar'] = $patientRepo->getAvatar($patient);
                    break;
                case Doctor::USER_TYPE:
                    $doctorRepo = new DoctorRepository(new Doctor());
                    $doctor = $doctorRepo->findByUserId($user->id);
                    $results['id'] = $doctorRepo->getUuid($user);
                    $results['dashboard_url'] = $app_settings['doctor_domain'];
                    $results['user_type'] = Doctor::USER_TYPE;
                    $results['first_name'] = $doctor->first_name;
                    $results['other_name'] = $doctor->other_name;
                    $results['avatar'] = $doctorRepo->getAvatar($doctor);
                    break;
                case Pharmacy::USER_TYPE:
                    $pharmacyRepo = new PharmacyRepository(new Pharmacy());
                    $pharmacy = $pharmacyRepo->findByUserId($user->id);
                    $results = $pharmacyRepo->transform($pharmacy);
                    break;
            }
        }
        return $results;

    }

//    public function showProfile(User $user){
//
//        $user_type = $this->getUserRole($user);
//
//        if ($user->assets()->get()->first()){
//            $asset = [
//                'id' => $user->assets()->get()->where('asset_type','Profile picture')->first()->uuid,
//                'file_path' => $user->assets()->get()->first()->file_path,
//                'file_size' => $user->assets()->get()->first()->file_size,
//                'file_type' => $user->assets()->get()->first()->file_type,
//            ];
//        }else{
//            $asset = [
//                'id' => '',
//                'file_path' => Config::get('settings.default_avatar'),
//                'file_size' => '',
//                'file_type' => '',
//            ];
//        }
//        return [
//            'id' => $user->uuid,
//            'email' => $user->email,
//            'mobile' => $user->mobile,
//            'uuid' => $user->uuid,
//            'username' => $user->username,
//            'status' => $user->status,
//            'user_type' => $user_type,
//            'assets' => $asset,
//        ];
//    }

//    public function getUserRole(User $user){
//        $roles = Role::all();
//        $user_type = "";
//        foreach ($roles as $role){
//            if ($user->hasRole($role->slug)){
//                $user_type = $role->slug;
//                return $user_type;
//            }
//        }
//        return $user_type;
//    }

//    public function getUserFullname(User $user){
//        $roles = Role::all();
//        $user_type = "";
//        foreach ($roles as $role){
//            if (  $user->hasRole('doctor') ){
//                $docy = $user->doctor()->get()->first();
//                $user_type = $docy->first_name.' '.$docy->last_name;
//            }elseif ( $user->hasRole('patient') ){
//                $docy = $user->patient()->get()->first();
//                $user_type = $docy->first_name.' '.$docy->last_name;
//            }
//        }
//        return $user_type;
//    }

//    public function transformDoctor(User $user){
//        $doctor = array();
//
//        $doctor['id'] = $user->doctor()->first()->uuid;
//        $doctor['salute'] = $user->doctor()->first()->salute;
//        $doctor['first_name'] = $user->doctor()->first()->first_name;
//        $doctor['last_name'] = $user->doctor()->first()->last_name;
//        $doctor['last_name'] = $user->doctor()->first()->last_name;
//        $doctor['registration_number'] = $user->doctor()->first()->registration_number;
//        $doctor['avatar'] = $user->doctor()->first()->avatar;
//        $doctor['address'] = $user->doctor()->first()->address;
//        $doctor['time_zone'] = $user->doctor()->first()->time_zone;
//        $doctor['mobile'] = $user->mobile;
//        $doctor['email'] = $user->email;
//        $doctor['gender'] = $user->gender;
//
//        return $doctor;
//
//    }

//    public function transformPatient(User $user){
//        $patient = array();
//        return $patient;
//    }

//    public function transformDoctorCollection($doctors){
//
//        $results = array();
//
//        foreach ($doctors as $doctor){
//            $temp_data['id'] = $doctor->id;
//            $temp_data['first_name'] = $doctor->first_name;
//            $temp_data['last_name'] = $doctor->last_name;
//            $temp_data['salute'] = $doctor->salute;
//            $temp_data['uuid'] = $doctor->user()->first()->uuid;
//            array_push($results, $temp_data);
//        }
//        return $results;
//    }

//    public function transformPatientCollect($patients){
//
//    }

//    public function getDependantRule(){
//        return [
//            'first_name' => 'required',
//            'last_name' => 'required',
//            'parent_id' => 'required',
//            'date_of_birth' => 'required',
//            'relationship' => 'required',
//            'gender' => 'required|in:Male,Female,Other',
//        ];
//    }

//    public function transformDependantCollection($dependants){
//
//        $results = array();
//
//        foreach ($dependants as $dependant){
//
//            $temp_data['id'] = $dependant->id;
//            $temp_data['first_name'] = $dependant->first_name;
//            $temp_data['last_name'] = $dependant->last_name;
//            $temp_data['gender'] = $dependant->gender;
//            $temp_data['date_of_birth'] = $dependant->dob;
//            array_push($results, $temp_data);
//        }
//
//        return $results;
//    }

//    public function createUserRule(){
//        return [
//            'username'=>'required|min:8|unique:users',
//            'account_type'=>'required',
//            'password'=>'required|confirmed|min:8',
//            'mobile'=>'required|unique:users',
//            'email'=>'required|unique:users',
//        ];
//    }

}

<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/14/18
 * Time: 3:57 PM
 */

namespace App\Repositories\User;


use App\Models\Doctor\Doctor;
use App\Models\Patient\HealthProfile;
use App\Models\Patient\Patient;
use App\Models\Pharmacy\Pharmacy;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeUser;
use App\Models\Specialist\Domains;
use App\Models\Specialist\Specialist;
use App\Models\Supplier\Supplier;
use App\Models\Users\Assets;
use App\Models\Users\User;
use App\Repositories\Doctor\DoctorRepository;
use App\Repositories\Patient\PatientRepository;
use App\Repositories\Pharmacy\PharmacyRepository;
use App\Repositories\Practice\PracticeRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;

class UserRepository implements UserRepositoryInterface
{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function storeRecord(array $arr)
    {
        // TODO: Implement storeRecord() method.
        return $this->model->create($arr);
    }

    public function storeRecords(array $arr)
    {
        // TODO: Implement storeRecords() method.
        $this->model->insert($arr);
    }


    public function findRecord($id)
    {
        // TODO: Implement findRecord() method.
        return $this->model->find($id);
    }

    public function find($id)
    {
        // TODO: Implement find() method.
        return $this->model->find($id);
    }


    public function getRecord()
    {
        // TODO: Implement getRecord() method.
        return $this->model->orderBy('created_at', 'desc')->paginate(25);
    }

//    public function setRecord(array $arr, $id)
//    {
//        // TODO: Implement setRecord() method.
//        return $this->model->where('id',$id)->update($arr);
//    }

    public function findByEmail($email)
    {
        // TODO: Implement findByEmail() method.
        return $this->model->all()->where('email',$email)->first();
    }

    public function getByEmail($email)
    {
        // TODO: Implement getByEmail() method.
        return $this->model->all()->where('email',$email);
    }


    public function findByEmailOrMobile($email_or_mobile)
    {
        // TODO: Implement findByEmailOrMobile() method.
        $user = $this->model->all()->where('mobile',$email_or_mobile)->first();
        if ($user){
            return $user;
        }else{
            $user = $this->model->all()->where('email',$email_or_mobile)->first();
            if ($user){
                return $user;
            }else{
                return false;
            }
        }
    }


    public function findByPhone($mobile)
    {
        // TODO: Implement findByPhone() method.
        return $this->model->all()->where('mobile',$mobile)->first();
    }


    public function findByUuid($uuid)
    {
        // TODO: Implement findByUuid() method.
        return $this->model->all()->where('uuid',$uuid)->first();
    }


    public function isPatient(User $user)
    {
        // TODO: Implement isPatient() method.
        $response = false;
        if ($user->hasRole('patient')){
            $response = true;
        }
        return $response;
    }

    public function isDoctor(User $user)
    {
        // TODO: Implement isDoctor() method.
        $response = false;
        if ($user->hasRole('doctor')){
            $response = true;
        }
        return $response;
    }

    public function isAdmin(User $user)
    {
        // TODO: Implement isAdmin() method.
        $response = false;
        if ($user->hasRole('admin')){
            $response = true;
        }
        return $response;
    }


    public function isSystemAdmin(User $user)
    {
        // TODO: Implement isSystemAdmin() method.
        $response = false;
        if ($user->hasRole('systemadmin')){
            $response = true;
        }
        return $response;
    }

    public function activated(User $user)
    {
        // TODO: Implement activated() method.
        if ($user->status == 'Activated'){
            return true;
        }
        return false;
    }

    public function findByToken($token)
    {
        // TODO: Implement findToken() method.
        return $this->model->all()->where('token',$token)->first();
    }

    public function activateUser(User $user)
    {
        // TODO: Implement activateUser() method.
        $user->status = 'Activated';
        $user->save();
    }

    public function deleteByUserId($user_id)
    {
        // TODO: Implement deleteByUserId() method.
        $this->model->where('user_id',$user_id)->delete();
    }

    public function setPassword(User $user, array $arr)
    {
        // TODO: Implement setPassword() method.
        $user->password = Hash::make($arr['password']);
        $user->save();
    }

    public function setProfile(User $user, array $arr)
    {
        // TODO: Implement setProfile() method.
        if ($this->isPatient($user)){
            $user->patient()->create($arr);
        }elseif($this->isDoctor($user)){
            $user->doctor()->create($arr);
        }
    }

    public function getProfile(User $user)
    {

        // TODO: Implement getProfile() method.

        if ($user->hasRole('patient')){
            return Patient::all()->where('user_id',$user->id)->first();
        }elseif($user->hasRole('doctor')){
            return Doctor::all()->where('user_id',$user->id)->first();
        }elseif($user->hasRole('pharmacy')){
            return Pharmacy::USER_TYPE;
        }else{
            $practiceUser = $user->practices()->get()->first();
            if ($practiceUser){
                return PracticeUser::USER_TYPE;
            }
        }

        switch ( $this->getUserType($user) ){
            case Patient::USER_TYPE:
                return Patient::all()->where('user_id',$user->id)->first();
                break;
            case Doctor::USER_TYPE:
                return Doctor::all()->where('user_id',$user->id)->first();
                break;
            case Pharmacy::USER_TYPE:
                return Pharmacy::all()->where('user_id',$user->id)->first();
                break;
            case PracticeUser::USER_TYPE:
                return PracticeUser::all()->where('user_id',$user->id)->first();
                break;
        }

    }


    public function update(array $arr, $uuid)
    {
        // TODO: Implement update() method.
        $this->model->where('uuid',$uuid)->update($arr);
    }

    public function delete($uuid)
    {
        // TODO: Implement delete() method.
        $this->model->where('uuid',$uuid)->delete();
    }

    public function attachRole(User $user, $slug)
    {
        // TODO: Implement attachRole() method.
        $role = Role::all()->where('slug',$slug)->first();
        $user->attachRole($role);
    }

    public function getAvatar(User $user)
    {
        // TODO: Implement getAvatar() method.

        if ( $user->assets()->get()->first() ){
            return $user->assets()->get()->first()->file_path;
        }
        return Config::get('settings.default_avatar');
    }

    public function attachToPractice(User $user, Practice $practice)
    {
        // TODO: Implement attachToPractice() method.
        $user->practices()->save($practice);
    }

    public function detachFromPractice(User $user, Practice $practice)
    {
        // TODO: Implement detachFromPractice() method.
        //$user->practices()->find($practice->id)->delete();
        DB::table('practices_users')
            ->where('user_id', '=', $user->id)
            ->where('practice_id', '=', $practice->id)
            ->delete();
    }

    public function exist_in_practice(User $user, Practice $practice)
    {
        // TODO: Implement exist_in_practice() method.
        if ( DB::table('practices_users')->where('user_id',$user->id)->where('user_id',$user->id)->get()->first() ){
            return true;
        }
        return false;
    }


    public function setPractice(User $user, $arr)
    {
        // TODO: Implement setPractice() method.
    }

    public function getPractice(User $user)
    {
        // TODO: Implement getPractice() method.
    }

    public function setDoctor(User $user, array $arr)
    {
        // TODO: Implement setDoctor() method.
        return $user->doctor()->create($arr);
    }

    public function setPatient(User $user, array $arr)
    {
        // TODO: Implement setPatient() method.
        return $user->patient()->create($arr);
    }

    public function setReceptionist(User $user, array $arr)
    {
        // TODO: Implement setReceptionist() method.
    }

//    public function deleteFromPracticeUsers(User $user)
//    {
//        // TODO: Implement deleteFromPracticeUsers() method.
//        return $user->practices()->delete();
//    }

    public function setNewPatient(array $arr)
    {
        // TODO: Implement setNewPatient() method.
        //create new user instance
        $arr['status'] = 'Activated';
        $user_data = $this->storeRecord($arr);
        //attach user patient role
        $role = Role::all()->where('slug','patient')->first();
        $user_data->attachRole($role);
        //create patient profile into doctors table
        $user_data->patient()->create($arr);
        //save profile picture assets
        $user_data->assets()->save(new Assets());
        return $user_data;
    }

    public function createProfile(array $arr)
    {
        // TODO: Implement createProfile() method.

        $new_user = $this->storeRecord($arr);
        $role = Role::all()->where('slug',$arr['user_type'])->first();
        $new_user->attachRole($role);
        switch ($arr['user_type']){
            case 'doctor':
                $new_user->doctor()->create($arr);
                break;
            case 'patient':
                $patient = $new_user->patient()->create($arr);
                $patient->health_profile()->save(new HealthProfile());
                break;
        }
        return $new_user;
    }

    public function getUserType(User $user)
    {
        // TODO: Implement getUserType() method.
        $results = array();

        if ($user->hasRole('patient')){
            array_push($results,Patient::USER_TYPE);
        }

        if ($user->hasRole('doctor')){
            array_push($results,Doctor::USER_TYPE);
        }

        if ($user->hasRole('pharmacy')){
            array_push($results,Pharmacy::USER_TYPE);
        }

        if ( $practiceUser = $user->practices()->get()->first() ){
            array_push($results,PracticeUser::USER_TYPE);
        }

        return $results;

    }

    public function createPassword($string_)
    {
        // TODO: Implement createPassword() method.
        if ($string_){
            return Hash::make($string_);
        }
        return false;
    }

    public function getAccounts(User $user)
    {
        // TODO: Implement getAccounts() method.
        $account_type = $this->getUserType($user);

        $accounts = array();
        for ( $k=0; $k < sizeof($account_type); $k++ ){
            switch ($account_type[$k]){
                case Patient::USER_TYPE:
                    $patientRepo = new PatientRepository(new Patient());
                    $acca['account_type'] = Patient::USER_TYPE;
                    $acca['data'] = $patientRepo->transform_profile($patientRepo->findPatientByUserId($user->id),'basic');
                    array_push($accounts,$acca);
                    break;
                case PracticeUser::USER_TYPE:
                    //$practiceUser = $practUserRepo->getAccounts($user);
                    $practUserRepo = new PracticeRepository(new PracticeUser());
                    $acca['account_type'] = PracticeUser::USER_TYPE;
                    $acca['data'] = $practUserRepo->getAccounts($user);
                    array_push($accounts,$acca);
                    break;
                case Pharmacy::USER_TYPE:
                    $pharmacyRepo = new PharmacyRepository(new Pharmacy());
                    $pharmacy = $pharmacyRepo->findByUserId($user->id);
                    $acca['account_type'] = Pharmacy::USER_TYPE;
                    $acca['data'] = $pharmacyRepo->transform($pharmacy);
                    array_push($accounts,$acca);
                    break;
                case Doctor::USER_TYPE:
                    $doctorRepo = new DoctorRepository(new Doctor());
                    $acca['account_type'] = Doctor::USER_TYPE;
                    $acca['data'] = $doctorRepo->transform_($doctorRepo->findByUserId($user->id));
                    array_push($accounts,$acca);
                    break;
            }
        }
        return $accounts;
    }

    public function getPermissions(User $user)
    {
        // TODO: Implement getPermissions() method.
        $res = array();
        $permissions = Permission::all()->groupBy('description');
        foreach ($permissions as $index => $permission){
            $temp_arr = array();
            $temp_data['category'] = $index;
            $temp_data['has_category'] = false;
            foreach ($permission as $perms){
                $temp_arr1['id'] = $perms->id;
                $temp_arr1['name'] = $perms->name;
                $temp_arr1['slug'] = $perms->slug;
                $temp_arr1['description'] = $perms->description;
                if ($user->hasPermission($perms)){
                    $temp_arr1['has_perm'] = true;
                    array_push($temp_arr, $temp_arr1);
                }
                array_push($temp_arr, $temp_arr1);
            }
            $temp_data['data'] = $temp_arr;
            array_push($res,$temp_data);
        }

        return $res;

    }

    public function getCreatedBy(User $user)
    {
        // TODO: Implement getCreatedBy() method.

        if ($user){
            $profile = $this->getProfile($user);

            if ($user->hasRole('patient')){
                //return Patient::all()->where('user_id',$user->id)->first();
                return Patient::all()->where('user_id',$user->id)->first()->first_name;
            }elseif($user->hasRole('doctor')){
                //return Doctor::all()->where('user_id',$user->id)->first();
                return Doctor::all()->where('user_id',$user->id)->first()->first_name;
            }elseif($user->hasRole('pharmacy')){
                //return Pharmacy::USER_TYPE;
                return "Admin";
            }else{
                $practiceUser = $user->practices()->get()->first();
                if ($practiceUser){
                    //return PracticeUser::USER_TYPE;
                    return PracticeUser::all()->where('user_id',$user->id)->first()->first_name;
                }
            }
        }
        return "";

    }


}

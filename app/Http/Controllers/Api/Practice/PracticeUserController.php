<?php

namespace App\Http\Controllers\Api\Practice;

use App\helpers\HelperFunctions;
use App\Models\Application\Settings;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeRole;
use App\Models\Practice\PracticeUser;
use App\Models\Users\Activation;
use App\Models\Users\User;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\User\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Traits\ActivationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use jeremykenedy\LaravelRoles\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Module\Module;
use App\Repositories\ModelRepository;
use App\Models\Practice\Department;
use App\Models\Practice\PracticeUserWorkPlace;
use App\Models\Product\Store\ProductStore;
use App\Repositories\Product\ProductReposity;

class PracticeUserController extends Controller
{
    use ActivationTrait;

    protected $practiceUsers;
    protected $practiceRole;
    protected $practice;
    protected $response_type;
    protected $helper;
    protected $user;
    protected $role;
    protected $departments;
    protected $stores;

    public function __construct(PracticeUser $practiceUser)
    {
        $this->practiceUsers = new PracticeRepository($practiceUser);
        $this->practice = new PracticeRepository(new Practice());
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->user = new UserRepository(new User());
        $this->practiceRole = new PracticeRepository(new PracticeRole());
        $this->role = new RoleRepository(new Role());
        $this->departments = new ModelRepository( new Department() );
        $this->stores = new ProductReposity(new ProductStore());
    }

    public function index(Request $request){
        $http_resp = $this->response_type['200'];
        $results = array();
        $practice = $this->practice->find($request->user()->company_id);
        $practice_users = $practice->users()->get();
        foreach( $practice_users as $practice_user ){

            $transformed_user = $this->practiceUsers->transform_user($practice_user);
            $company = $this->practice->find($practice_user->getCompanyId());
            if($company){
                $transformed_user['facility'] = $this->practice->transform_company($company);
            }else{
                $transformed_user['facility'] = null;
            }
            array_push($results,$transformed_user);
        }
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }

    public function show($uuid){
        $http_resp = $this->response_type['200'];
        $practice_user = $this->practiceUsers->findByUuid($uuid);
        $transformed_user = $this->practiceUsers->transform_user($practice_user);
        $company = $this->practice->find($practice_user->getCompanyId());
        if($company){
            $transformed_user['facility'] = $this->practice->transform_company($company);
        }else{
            $transformed_user['facility'] = null;
        }
        $http_resp['results'] = $transformed_user;
        return response()->json($http_resp);
    }

    public function create(Request $request){
        Log::info($request);
        $http_resp = $this->response_type['200'];
        $rules = [
            'first_name'=>'required',
            'other_name'=>'required',
            'mobile'=>'required',
            'email'=>'required',
            //'practice_id'=>'required',
            'role_id'=>'required',
            //'branch_id'=>'required',
            'mail_invitation'=>'required',
            //'department_id'=> 'required',
        ];
        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        $encoded_mobile = $this->helper->encode_mobile($request->mobile,'KE');
        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try{
            //get main branch
            $practice = $this->practice->find($request->user()->company_id);
            $practice_main = $this->practice->findOwner($practice);
            $company = $this->practice->findByUuid($request->company_id);
            //user record to be used to login to the system
            $record = $request->except(['first_name','other_name','gender','role_name','practice_id','address','store_id','sub_store_id','department_id']);
            $record['password'] = $this->user->createPassword($request->password);
            $record['status'] = "Activated";
            $record['email_verified'] = true;
            $record['mobile_verified'] = true;
            $record['status'] = "Activated";
            $record['mobile'] = $encoded_mobile;
            $record['company_id'] = $company->id;
            $logins = $this->user->storeRecord($record);
            //set practice user record and permissions
            $practice_user = $request->all();

            $practice_user['practice_id'] = $practice->id;
            $practice_user['user_id'] = $logins->id;
            $practice_user['mobile'] = $encoded_mobile;
            if( PracticeUser::all()->where('mobile',$encoded_mobile)->first() ){
                DB::connection(Module::MYSQL_DB_CONN)->rollBack();
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = ['Mobile number '.$encoded_mobile.' already in use!'];
                return response()->json($http_resp,422);
            }
            if( PracticeUser::all()->where('email',$request->email)->first() ){
                DB::connection(Module::MYSQL_DB_CONN)->rollBack();
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = ['Email address '.$request->email.' already in use!'];
                return response()->json($http_resp,422);
            }

            $respo = null;
            if($practice_user['branch_id'] != 0){
                $branch = $this->practice->findByUuid($request->branch_id);
                $respo = $this->practiceUsers->setUser($branch, $practice_user);
                $practice_user['facility'] = true;
            }else{
                $practice_user['facility'] = false;
                $respo = $this->practiceUsers->setUser($practice, $practice_user);
            }

            if ($respo){
                //$practice_use = $respo['message'];
                //$this->practiceUsers->setPermission($practice_use,$request->permissions);
                //attach user a role
                $practiceRole = PracticeRole::find($request->role_id);
                $this->practiceUsers->attachRole($respo,$practiceRole);
                
                //if user is assigned to a department
                $practiceUserWork = new PracticeUserWorkPlace();
                if($request->department_id){
                    $branch = $this->practice->findByUuid($request->branch_id);
                    $department = $this->departments->findByUuid($request->department_id);
                    $practiceUserWork->department_id = $department->id;
                    $practiceUserWork->practice_id = $branch->id;
                    $practiceUserWork->practice_user_id = $respo->id;
                    $practiceUserWork->save();
                }
                if($request->store_id){
                    $store = $this->stores->findByUuid($request->store_id);
                    $practiceUserWork->store_id = $store->id;
                    $practiceUserWork->save();
                }
                if($request->sub_store_id){
                    $sstore = $this->stores->findByUuid($request->sub_store_id);
                    $practiceUserWork->sub_store_id = $sstore->id;
                    $practiceUserWork->save();
                }

                if($request->branch_id != 0){
                    $branch = $this->practice->findByUuid($request->branch_id);
                    $practice = $branch;
                    $practiceUserWork->practice_id = $branch->id;
                    $practiceUserWork->practice_user_id = $respo->id;
                    $practiceUserWork->save();
                }

                if ($request->mail_invitation){
                    $practice_us['status'] = 'Invited';
                    //initiate invite by sending invitation email to user
                    $other_data['send_to'] = $respo->first_name;
                    $other_data['name'] = "Master admin";
                    $other_data['uuid'] = $practice->uuid;
                    $this->initiatePracticeUserInvitation($logins,$practice,$other_data);
                    $this->practiceUsers->update($practice_us, $respo->uuid);
                }else{
                    $practice_user['status'] = 'Active';
                }

                $http_resp['description'] = "Created successful!";

            }else{
                DB::connection(Module::MYSQL_DB_CONN)->rollBack();
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = [$respo['message']];
                return response()->json($http_resp,422);
            }

        }catch (\Exception $exception){
            $http_resp = $this->response_type['500'];
            Log::info($exception);
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function update(Request $request,$uuid){

        $http_resp = $this->response_type['200'];
        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try{
            $practiceUser = $this->practiceUsers->findByUuid($uuid);
            $practiceUser->update($request->except(['email']));
            $http_resp['description'] = "Your profile successful updated!";
        }catch (\Exception $exception){
            $http_resp = $this->response_type['500'];
            Log::info($exception);
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        return response()->json($http_resp);

    }

    public function destroy($uuid){
        $http_resp = $this->response_type['200'];
        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try{
            $practiceUser = $this->practiceUsers->findByUuid($uuid);
            $usery = PracticeUser::find($practiceUser->id);
            $usery->detachAllRoles();
            $this->practiceUsers->delete($uuid);
            $http_resp['description'] = "User deleted successful!";
        }catch (\Exception $exception){
            $http_resp = $this->response_type['500'];
            Log::info($exception);
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        return response()->json($http_resp);
    }

//    public function invite(Request $request){
//
//        $http_resp = $this->response_type['200'];
//
//        $rules = [
//            'practice_user_uuid'=>'required',
//            'practice_id'=>'required',
//        ];
//        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
//        if ($validation->fails()){
//            $http_resp = $this->response_type['422'];
//            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
//            return response()->json($http_resp,422);
//        }
//
//        try{
//
//            $practice = $this->practice->findByUuid($request->practice_id);
//            $practiceUser = $this->practiceUsers->findByUuid($request->practice_user_uuid);
//            $user = $this->user->findRecord($practiceUser->user_id);
//            $other_data['send_to'] = $practiceUser->first_name;
//            $other_data['name'] = "Master admin";
//            $other_data['uuid'] = $practice->uuid;
//            $this->initiatePracticeUserInvitation($user,$practice,$other_data);
//            $http_resp['description'] = "Invitation sent successful!";
//
//        }catch (\Exception $exception){
//            $http_resp = $this->response_type['500'];
//            Log::info($exception);
//            DB::rollBack();
//            return response()->json($http_resp,500);
//        }
//        DB::commit();
//        return response()->json($http_resp);
//    }
//
//    public function master(Request $request){
//
//        $http_resp = $this->response_type['200'];
//
//        $rules = [
//            'practice_user_uuid'=>'required',
//            'practice_id'=>'required',
//        ];
//        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
//        if ($validation->fails()){
//            $http_resp = $this->response_type['422'];
//            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
//            return response()->json($http_resp,422);
//        }
//
//        try{
//
//            $practice = $this->practice->findByUuid($request->practice_id);
//            $practiceUser = $this->practiceUsers->findByUuid($request->practice_user_uuid);
//            $user = $this->user->findRecord($practiceUser->user_id);
//            //$this->initiatePracticeUserInvitation($user,$practice);
//            $session_user = $request->user();
//            $sessionpracticeUser = $this->practiceUsers->findByUserIdPracticeId($session_user->id,$practice->id,$session_user->email);
//
//            $activation = new Activation();
//            $activation->token = $this->helper->getToken(60);
//            $activation->owner_id = $user->id;
//            $activation->owner_type = $practice->uuid;
//            $activation->save();
//
//            $mail_data = $practice->toArray();
//            $mail_data['practice_name'] = $practice->name;
//            $mail_data['send_by'] = $sessionpracticeUser->first_name;
//            $mail_data['send_to'] = $practiceUser->first_name;
//            $mail_data['token'] = $activation->token;
//            $this->initiateMails($user, Settings::MAKE_MASTER_ADMIN,$mail_data);
//            $http_resp['description'] = $practiceUser->first_name." ".$practiceUser->other_name." was invited to be master admin";
//
//        }catch (\Exception $exception){
//            $http_resp = $this->response_type['500'];
//            Log::info($exception);
//            DB::rollBack();
//            return response()->json($http_resp,500);
//        }
//        DB::commit();
//        return response()->json($http_resp);
//    }

}

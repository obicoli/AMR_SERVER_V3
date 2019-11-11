<?php

namespace App\Http\Controllers\Api\Practice;

use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeUsers;
use App\Models\Users\Patient;
use App\Models\Users\User;
use App\Repositories\Patient\PatientRepository;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Practice\PracticeUserRepository;
use App\Repositories\User\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Traits\ActivationTrait;
use App\Transformers\User\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use jeremykenedy\LaravelRoles\Models\Role;

class PracticePatientController extends Controller
{
    use ActivationTrait;
    protected $practice;
    protected $practiceUser;
    protected $patient;
    protected $response_type;
    protected $helper;
    protected $user;
    protected $role;
    protected $user_transformer;

    public function __construct()
    {
        $this->practice = new PracticeRepository(new Practice());
        $this->role = new RoleRepository(new Role());
        $this->patient = new PatientRepository(new Patient());
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->user = new UserRepository(new User());
        $this->user_transformer = new UserTransformer();
        $this->practiceUser = new PracticeUserRepository(new PracticeUsers());
    }

    public function index(Request $request,$uuid){

        $http_resp = $this->response_type['200'];
        $practice = $this->practice->findByUuid($uuid);
        $practice_users = $this->practiceUser->getByPracticeId($practice->id);

        $response = [

            'pagination' => [
                'total' => $practice_users->total(),
                'per_page' => $practice_users->perPage(),
                'current_page' => $practice_users->currentPage(),
                'last_page' => $practice_users->lastPage(),
                'from' => $practice_users->firstItem(),
                'to' => $practice_users->lastItem()
            ],
            'data' => $this->user_transformer->transformPracticePatients($practice_users, $uuid)
        ];
        $http_resp['results'] = $response;
        return response()->json($http_resp);

    }

    public function create(Request $request){

        $http_resp = $this->response_type['200'];
        $rule = [
            //'user_role' => 'required',
            'email' => 'required|unique:users',
            'mobile' => 'required|unique:users',
            'practice_id' => 'required'
        ];

        $uuid = $request->practice_id;

        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validator->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{
            $practice = $this->practice->findByUuid($uuid);
            $user = $this->user->findByEmail($request->email);
            $user_role = $this->role->findBySlug('patient');
            if (!$user){
                $inputs = $request->all();
                $inputs['status'] = 'Activated';
                $user = $this->user->storeRecord($request->all());
                if ($user_role->slug == 'doctor'){
                    $this->user->setDoctor($user, $request->except(['email','mobile']));
                }elseif ($user_role->slug == 'patient'){
                    $this->user->setPatient($user, $request->except(['email','mobile']));
                }elseif ($user_role->slug == 'receptionist'){

                }
                $this->user->attachRole($user, $user_role->slug);
            }
            //check if user already exists in practice
            if ($this->user->exist_in_practice($user, $practice)){
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = ['User with similar email already invited in this practice'];
                return response()->json($http_resp,422);
            }
            //add user to practice
            $this->user->attachToPractice($user, $practice);
            //attach practice role to user
            $practice_user = $this->practiceUser->findPracticeUser($practice, $user);
            $this->practiceUser->setConfirmed($practice_user, false);
            $this->practiceUser->attachRole($practice_user, $user_role);
            //send user an email
            //$inviter_name = $practice->name;
            //$this->initiatePracticeUserInvitation($user, $practice);
        }catch (\Exception $e){
            Log::info($e);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp, 500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function show(Request $request, $practice_uuid, $patient_uuid){

        $http_resp = $this->response_type['200'];
        $patient = $this->patient->findByUuid($patient_uuid);
        $practice = $this->practice->findByUuid($practice_uuid);
        $user = $this->user->findRecord($patient->user_id);
        $results = $this->user_transformer->transformPracticePatient($user, $practice, $patient);
        $http_resp['results'] = $results;
        return response()->json($http_resp);

    }

}

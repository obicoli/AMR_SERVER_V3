<?php

namespace App\Http\Controllers\Api\Practice;

use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeRole;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\User\RoleRepository;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Module\Module;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;

class PracticeRoleController extends Controller
{

    protected $practiceRole;
    protected $practice;
    protected $role;
    protected $response_type;
    protected $helper;

    public function __construct(PracticeRole $practiceRole)
    {
        $this->practiceRole = new PracticeRepository($practiceRole);
        $this->practice = new PracticeRepository(new Practice());
        $this->role = new RoleRepository(new Role());
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();

    }

    public function index(Request $request){
        $http_resp = $this->response_type['200'];
        $practice = $this->practice->find($request->user()->company_id);
        $results = array();
        $practice_roles = $practice->roles()->get()->sortBy('name');
        foreach( $practice_roles as $practice_role ){
            array_push($results,$this->practice->transform_role($practice_role,$practice));
        }
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }

    public function show($id){
        $http_resp = $this->response_type['200'];
        $http_resp['results'] = $this->practice->getRole($id);
        return response()->json($http_resp);
    }

    // public function practice($practice_uuid){
    //     Log::info($practice_uuid);
    //     $http_resp = $this->response_type['200'];
    //     $practice = $this->practice->findByUuid($practice_uuid);
    //     $practice = $this->practice->findOwner($practice);
    //     Log::info($practice);
    //     $http_resp['results'] = $this->practiceRole->getPracticeRoles($practice);
    //     return response()->json($http_resp);
    // }

    public function create(Request $request){
        //Log::info($request);
        $http_resp = $this->response_type['200'];
        $rules = [
            'name',
            'description',
        ];
        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try{
            $practice = $this->practice->find($request->user()->company_id);
            $practiceMain = $this->practice->findOwner($practice);
            $practice_role = $request->all();
            $practice_role['practice_id'] = $practiceMain->id;
            $practice_role['slug'] = str_replace(" ",".",strtolower($request->name));
            //$this->practiceRole->setRole($practice_role);
            if($practiceMain->roles()->where('name',$request->name)->get()->first()){
                DB::connection(Module::MYSQL_DB_CONN)->rollBack();
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = ["Role already exist!"];
                return response()->json($http_resp,422);
            }
            $practice_rol = $this->practiceRole->create($practice_role);
            if( $request->has("permissions") ){
                $practice_rol->detachAllPermissions();
                $permissions = $request->permissions;
                for( $i=0; $i < sizeof($permissions); $i++ ){
                    $permission = Permission::find($permissions[$i]);
                    $practice_rol->attachPermission($permission);
                }
            }
            
            $http_resp['description'] = "Role successful added";

        }catch (\Exception $exception){
            Log::info($exception);
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }

        DB::connection(Module::MYSQL_DB_CONN)->commit();
        return response()->json($http_resp);

    }

    public function update(Request $request, $id){

        $http_resp = $this->response_type['200'];
        $rules = [
            'name',
            'description',
        ];

        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try{

            //$role = Role::find();
            $role = PracticeRole::find($id);
            $role->update($request->all());
            if( $request->has("permissions") ){
                $role->detachAllPermissions();
                $permissions = $request->permissions;
                for( $i=0; $i < sizeof($permissions); $i++ ){
                    $permission = Permission::find($permissions[$i]);
                    $role->attachPermission($permission);
                }
            }

        }catch (\Exception $exception){
            Log::info($exception);
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        return response()->json($http_resp);

    }

    public function destroy($id){
        $http_resp = $this->response_type['200'];
        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try{

            $role = $this->practiceRole->find($id);
            $role->detachAllPermissions();
            $role->delete();
            $http_resp['description'] = "Deleted successful!f";

        }catch(\Exception $e){

            Log::info($e);
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);

        }
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        return response()->json($http_resp);
    }

}

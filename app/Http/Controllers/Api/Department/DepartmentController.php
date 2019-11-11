<?php

namespace App\Http\Controllers\Api\Department;

use App\helpers\HelperFunctions;
use App\Models\Pharmacy\Pharmacy;
use App\Models\Practice\Department;
use App\Models\Practice\Practice;
use App\Models\Users\User;
use App\Repositories\Pharmacy\PharmacyRepository;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    protected $department;
    protected $response_type;
    protected $helper;
    protected $user;
    protected $pharmacy;
    protected $practice;

    public function __construct(Department $department)
    {
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->department = new PracticeRepository($department);
        $this->user = new UserRepository(new User());
        $this->pharmacy = new PharmacyRepository(new Pharmacy());
        $this->practice = new PracticeRepository(new Practice());
    }

    public function index(Request $request){

        $http_resp = $this->response_type['200'];
        $user = $request->user();
        switch ( $this->user->getUserType($user) ){
            case Pharmacy::USER_TYPE:
                $pharmacy = $this->pharmacy->findByUserId($user->id);
                $http_resp['results'] = $this->practice->getDepartment(null, $pharmacy);
                break;
        }
        return response()->json($http_resp);

    }

    public function practice($practice_uuid){

        $http_resp = $this->response_type['200'];
        $results = array();
        $practice = $this->practice->findByUuid($practice_uuid);
        $owner = $this->practice->findParent($practice);
        $departments = $owner->departments()->get()->sortBy('name');

        foreach( $departments as $department ){
            $temp_data['id'] = $department->uuid;
            $temp_data['name'] = $department->name;
            array_push($results, $temp_data);
        }

        $http_resp['results'] = $results;
        // $user = $request->user();
        // switch ( $this->user->getUserType($user) ){
        //     case Pharmacy::USER_TYPE:
        //         $pharmacy = $this->pharmacy->findByUserId($user->id);
        //         $http_resp['results'] = $this->practice->getDepartment(null, $pharmacy);
        //         break;
        // }
        return response()->json($http_resp);

    }

    public function create(Request $request){
        $http_resp = $this->response_type['200'];
        $rules = [
            'name' => 'required',
            'status' => 'required',
            'description' => 'required',
            'branch_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ( $validator->fails() ){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validator->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{
            //get branch data
            //get main account/branch/owner
            $branch = $this->practice->findByUuid($request->branch_id);
            $practice = $this->practice->findOwner($branch);
            $respo = $this->practice->setDepartment($practice,$request->all());
            if ($respo){
                $http_resp['description'] = "Created successful!";
            }else{
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = ['Department already exists'];
                return response()->json($http_resp,422);
            }

        }catch (\Exception $exception){
            Log::info($exception);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function update(Request $request,$uuid){

        $rules = [
            'name' => 'required',
            'status' => 'required',
            'description' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ( $validator->fails() ){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validator->errors());
            return response()->json($http_resp,422);
        }

        $http_resp = $this->response_type['200'];
        DB::beginTransaction();
        try{
            $depart = $this->practiceDepartment->findByUuid($uuid);
            $department = $this->department->find($depart->department_id);
            $this->department->update($request->except(['branch_id']),$department->uuid);
            $this->practiceDepartment->update($request->except(['branch_id','name']),$uuid);
            $http_resp['description'] = "Updated successful!";
        }catch (\Exception $exception){
            Log::info($exception);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function show($uuid){}

    public function destroy($uuid){
        $http_resp = $this->response_type['200'];
        DB::beginTransaction();
        try{
            $depart = $this->practiceDepartment->findByUuid($uuid);
            $depart->delete();
            $http_resp['description'] = "Deleted successful!";
            //$respo = $this->department->deleteDepartment($uuid);
        }catch (\Exception $exception){
            Log::info($exception);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }
}

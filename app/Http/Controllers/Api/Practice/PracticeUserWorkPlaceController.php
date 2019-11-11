<?php

namespace App\Http\Controllers\Api\Practice;

use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeDepartment;
use App\Models\Practice\PracticeUser;
use App\Models\Practice\PracticeUserWorkPlace;
use App\Repositories\Practice\PracticeRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PracticeUserWorkPlaceController extends Controller
{
    protected $practiceUserWorkPlace;
    protected $practiceDepartment;
    protected $practiceUser;
    protected $practice;
    protected $response_type;
    protected $helper;

    public function __construct(PracticeUserWorkPlace $practiceUserWorkPlace)
    {
        $this->practiceUserWorkPlace = new PracticeRepository($practiceUserWorkPlace);
        $this->practice = new PracticeRepository(new Practice());
        $this->practiceDepartment = new PracticeRepository(new PracticeDepartment());
        $this->practiceUser = new PracticeRepository(new PracticeUser());
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function index(Request $request){}
    public function create(Request $request){

        Log::info($request);
        $http_resp = $this->response_type['200'];
        $rules = [
            'branch_id'=>'required',
            'practice_user_id'=>'required',
            'practice_department_id'=>'required',
        ];

        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{

            $practice_department = $this->practiceDepartment->findByUuid($request->practice_department_id);
            $practice = $this->practice->findByUuid($request->branch_id);
            $practiceUser = $this->practiceUser->findByUuid($request->practice_user_id);
            $inputs = $request->all();
            $inputs['practice_department_id'] = $practice_department->id;
            $inputs['practice_user_id'] = $practiceUser->id;
            $inputs['practice_id'] = $practice->id;
            $this->practiceUser->setWorkPlace($practiceUser, $inputs);

        }catch (\Exception $exception){
            $http_resp = $this->response_type['500'];
            Log::info($exception);
            DB::rollBack();
            return response()->json($http_resp,500);
        }

        DB::commit();
        return response()->json($http_resp,200);

    }
}

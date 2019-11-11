<?php

namespace App\Http\Controllers\Api\Practice;

use App\helpers\HelperFunctions;
use App\Models\Pharmacy\Pharmacy;
use App\Models\Practice\Department;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeStore;
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

class StoresController extends Controller
{

    protected $practiceStore;
    protected $response_type;
    protected $helper;
    protected $user;
    protected $pharmacy;
    protected $practice;

    public function __construct(PracticeStore $practiceStore)
    {
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practiceStore = new PracticeRepository($practiceStore);
        $this->user = new UserRepository(new User());
        $this->pharmacy = new PharmacyRepository(new Pharmacy());
        $this->practice = new PracticeRepository(new Practice());
    }

    public function index(Request $request){}
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
            $respo = $this->practiceStore->setStore($request);
            if ($respo){
                $http_resp['description'] = $respo;
            }else{
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = ['Store already exists'];
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

}

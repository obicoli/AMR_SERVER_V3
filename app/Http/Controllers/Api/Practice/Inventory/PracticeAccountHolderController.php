<?php

namespace App\Http\Controllers\Api\Practice\Inventory;

use App\helpers\HelperFunctions;
use App\Models\Practice\Inventory\PracticeAccountHolder;
use App\Models\Practice\Practice;
use App\Repositories\Practice\PracticeRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PracticeAccountHolderController extends Controller
{
    protected $practice;
    protected $practiceAccountHolder;
    protected $response_type;
    protected $helper;

    public function __construct(Practice $practice)
    {
        $this->practice = new PracticeRepository($practice);
        $this->practiceAccountHolder = new PracticeRepository(new PracticeAccountHolder());
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function index(){
        $http_resp = $this->response_type['200'];
        return response()->json($http_resp);
    }

    public function create(Request $request){

        Log::info($request);

        $http_resp = $this->response_type['200'];
        $rules = [
            'title'=>'required',
            'email'=>'required|unique:practice_account_holders',
            'address'=>'required',
            'mobile'=>'required|unique:practice_account_holders',
            'company_name'=>'required',
            'country'=>'required',
            'town'=>'required',
            'national_id'=>'required|unique:practice_account_holders',
            'practice_id'=>'required',
        ];
        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        DB::beginTransaction();
        try{
            $inputs = $request->except(['practice_id']);
            $practice = $this->practice->findByUuid($request->practice_id);
            $practice = $this->practice->findOwner($practice);
            $this->practice->setAccountHolder($practice, $inputs);

        }catch (\Exception $exception){
            Log::info($exception);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);

    }

    public function update(Request $request){
        $http_resp = $this->response_type['200'];
        return response()->json($http_resp);
    }

    public function destroy($uuid){
        $http_resp = $this->response_type['200'];
        $account_holder = $this->practiceAccountHolder->findByUuid($uuid);
        $this->practiceAccountHolder->delete($uuid);
        return response()->json($http_resp);
    }

    public function show($uuid){
        $http_resp = $this->response_type['200'];
        return response()->json($http_resp);
    }

}

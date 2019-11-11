<?php

namespace App\Http\Controllers\Api\Practice;

use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeUser;
use App\Repositories\Practice\PracticeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PracticeUserPermissionController extends Controller
{

    protected $response_type;
    protected $helper;
    protected $practiceUser;

    public function __construct(PracticeUser $practiceUser)
    {
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practiceUser = new PracticeRepository($practiceUser);
    }

    public function create(Request $request){

        $http_resp = $this->response_type['200'];

        $rule = [
            'practice_user_id'=>'required',
            'permissions'=>'required',
        ];

        $validation = Validator::make($request->all(),$rule);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{
            $practiceUser = $this->practiceUser->findByUuid($request->practice_user_id);
            $this->practiceUser->setPermission($practiceUser, $request->except(['practice_user_id']));
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

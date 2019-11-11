<?php

namespace App\Http\Controllers\Api\Product\Accounts;

use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Models\Product\Accounts\ProductAccountDetailType;
use App\Models\Product\Accounts\ProductAccountType;
use App\Models\Product\Accounts\ProductChartAccount;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductChartAccountController extends Controller
{
    protected $productChartAccount;
    protected $accountType;
    protected $accountTypeDetail;
    protected $practice;
    protected $response_type;
    protected $helper;

    public function __construct(ProductChartAccount $productChartAccount)
    {
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productChartAccount = new ProductReposity($productChartAccount);
        $this->accountType = new ProductReposity(new ProductAccountType());
        $this->accountTypeDetail = new ProductReposity(new ProductAccountDetailType());
        $this->practice = new PracticeRepository(new Practice());
    }

    public function index(Request $request){}

    public function create(Request $request){
        //Log::info($request);
        $http_resp = $this->response_type['200'];
        $rules = [
            'name'=>'required',
            'balance'=>'required',
            'description'=>'required',
            'practice_id'=>'required',
            'is_sub_account'=>'required',
            'as_at'=>'required',
            'account_type_id'=>'required',
            'account_details_id'=>'required',
        ];
        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        DB::beginTransaction();

        try{

            $practice = $this->practice->findByUuid($request->practice_id);
            $accountType = $this->accountType->findByUuid($request->account_type_id);
            $accountTypeDetails = $this->accountTypeDetail->findByUuid($request->account_details_id);
            $set_coa = $this->productChartAccount->setCOA($practice,$accountType,$accountTypeDetails,$request->all());
            if ($set_coa['status']){

            }else{
                DB::rollBack();
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = [$set_coa['message']];
                return response()->json($http_resp,422);
            }

        }catch (\Exception $exception){
            $http_resp = $this->response_type['500'];
            Log::info($exception);
            DB::rollBack();
            return response()->json($http_resp,500);
        }

        DB::commit();
        return response()->json($http_resp);
    }

    public function update(Request $request,$uuid){}
    public function show($uuid){}
    public function destroy($uuid){}

}

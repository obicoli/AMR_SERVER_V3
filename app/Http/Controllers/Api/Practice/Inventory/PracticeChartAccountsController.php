<?php

namespace App\Http\Controllers\Api\Practice\Inventory;

use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Models\Product\Accounts\ProductAccountNature;
use App\Models\Product\Accounts\ProductAccountType;
use App\Models\Product\Accounts\ProductChartAccount;
use App\Models\Product\Product;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PracticeChartAccountsController extends Controller
{

    protected $productChartAccount;
    protected $response_type;
    protected $helper;
    protected $user;
    protected $practice;
    protected $accountNature;
    protected $accountType;

    public function __construct(ProductChartAccount $productChartAccount)
    {
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productChartAccount = new ProductReposity($productChartAccount);
        $this->practice = new PracticeRepository(new Practice());
        $this->accountNature = new ProductReposity(new ProductAccountNature());
        $this->accountType = new ProductReposity(new ProductAccountType());
    }

    public function index(Request $request){
        $http_resp = $this->response_type['200'];
    }

    public function create(Request $request){
        $http_resp = $this->response_type['200'];
        $rules = [
            'nature_id'=>'required',
            'type_id'=>'required',
            'practice_id'=>'required',
            'name'=>'required',
        ];
        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        DB::beginTransaction();
        try{

            $practice = $this->practice->findByUuid($request->practice_id);
            $practice = $this->practice->findOwner($practice);
            $account_nature = $this->accountNature->findByUuid($request->nature_id);
            $account_type = $this->accountType->findByUuid($request->type_id);
            $inputs = $request->except(['nature_id','type_id']);
            $inputs['practice_id'] = $practice->id;
            $inputs['product_account_nature_id'] = $account_nature->id;
            $inputs['product_account_type_id'] = $account_type->id;
            if (!$this->practice->setChartAccount($practice,$inputs)){
                DB::rollBack();
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = ['Account already exists'];
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

        $http_resp = $this->response_type['200'];
        $rules = [
            'nature_id'=>'required',
            'type_id'=>'required',
            'name'=>'required',
        ];
        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        DB::beginTransaction();
        try{
            $account_nature = $this->accountNature->findByUuid($request->nature_id);
            $account_type = $this->accountType->findByUuid($request->type_id);
            $productChartAccount = $this->productChartAccount->findByUuid($uuid);
            $inputs = $request->except(['nature_id','type_id']);
            //$inputs['practice_id'] = $practice->id;
            $inputs['product_account_nature_id'] = $account_nature->id;
            $inputs['product_account_type_id'] = $account_type->id;
            $this->productChartAccount->update($inputs,$productChartAccount->id);
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
        $productChartAccount = $this->productChartAccount->findByUuid($uuid);
        $this->productChartAccount->destroy($productChartAccount->id);
        return response()->json($http_resp);
    }

}

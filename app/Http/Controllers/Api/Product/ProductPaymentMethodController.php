<?php

namespace App\Http\Controllers\Api\Product;

use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Models\Product\ProductPaymentMethod;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductPaymentMethodController extends Controller
{
    protected $productPaymentMethod;
    protected $practice;
    protected $http_response;
    protected $helper;

    public function __construct(ProductPaymentMethod $productPaymentMethod)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productPaymentMethod = new ProductReposity($productPaymentMethod);
        $this->practice = new PracticeRepository(new Practice());
    }

    public function index(Request $request){}
    public function create(Request $request){
        $http_resp = $this->http_response['200'];
        $rules = [
            'name'=>'required',
            'vendor_fee'=>'required',
            'payment_type'=>'required',
            'practice_id'=>'required',
        ];
        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();

        try{

            $inputs = $request->all();
            $inputs['payment_type_id'] = $request->payment_type;
            $practice = $this->practice->findByUuid($request->practice_id);
            $practice = $this->practice->findOwner($practice);
            $this->practice->setPaymentMethod($practice,$inputs);
            $http_resp['description'] = "Created successful!";

        }catch (\Exception $exception){
            $http_resp = $this->http_response['500'];
            Log::info($exception);
            DB::rollBack();
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);

    }
    public function update(Request $request,$uuid){

        $http_resp = $this->http_response['200'];
        $rules = [
            'name'=>'required',
            'vendor_fee'=>'required',
            'payment_type'=>'required',
        ];
        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();

        try{

            $inputs = $request->except(['practice_id']);
            $inputs['payment_type_id'] = $request->payment_type;
            $method_pay = $this->productPaymentMethod->findByUuid($uuid);
            $this->productPaymentMethod->update($inputs,$method_pay->id);
            $http_resp['description'] = "Updated successful!";

        }catch (\Exception $exception){
            $http_resp = $this->http_response['500'];
            Log::info($exception);
            DB::rollBack();
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);

    }
    public function show($uuid){}
    public function destroy($uuid){
        $http_resp = $this->http_response['200'];
        $taxes = $this->productPaymentMethod->findByUuid($uuid);
        $taxes->delete();
        $http_resp['description'] = "Deleted successful!";
        return response()->json($http_resp);
    }
}

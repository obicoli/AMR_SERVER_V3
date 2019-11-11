<?php

namespace App\Http\Controllers\Api\Product;

use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Models\Product\ProductSalesCharge;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductSalesChargeController extends Controller
{
    protected $productSalesCharge;
    protected $practice;
    protected $http_response;
    protected $helper;

    public function __construct(ProductSalesCharge $productSalesCharge)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productSalesCharge = new ProductReposity($productSalesCharge);
        $this->practice = new PracticeRepository(new Practice());
    }

    public function index(Request $request, $practice_uuid){
        $http_resp = $this->http_response['200'];
        $practice = $this->practice->findByUuid($practice_uuid);
        $http_resp['results'] = $this->productSalesCharge->getItemSalesCharge($practice);
        return response()->json($http_resp);
    }

    //practice
    public function practice($practice_uuid){
        $http_resp = $this->http_response['200'];
        $practice = $this->practice->findByUuid($practice_uuid);
        $http_resp['results'] = $this->productSalesCharge->getItemSalesCharge($practice);
        return response()->json($http_resp);
    }

    public function create(Request $request){

        Log::info($request);

        $http_resp = $this->http_response['200'];
        $rules = [
            'practice_id' => 'required',
            'name' => 'required',
            // 'agent_name' => 'required',
            // 'registration_number',
            // 'description' => 'required',
            // 'start_period' => 'required',
            // 'filling_frequency' => 'required',
            // 'reporting_method' => 'required',
            // 'collected_on_sales' => 'required',
            // 'sales_rate' => 'required',
            // 'purchase_rate' => 'required',
            // 'collected_on_purchase' => 'required',
            'amount' => 'required',
        ];

        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();

        try{

            $practice = $this->practice->findByUuid($request->practice_id);
            //$practice = $this->practice->findOwner($practice);
            $parentPractice = $this->practice->findParent($practice);
            $inputs = $request->all();
            $inputs['practice_id'] = $practice->id;
            $inputs['start_period'] = date('Y-m-d H:i:s');//date('Y').'-'.$request->start_period.'-d H:i:s';
            //$this->productSalesCharge->create($inputs);
            $this->productSalesCharge->setTax($parentPractice,$inputs);
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
            //'practice_id' => 'required',
            //'name' => 'required',
            // 'agent_name' => 'required',
            // 'registration_number',
            // 'description' => 'required',
            // 'start_period' => 'required',
            // 'filling_frequency' => 'required',
            // 'reporting_method' => 'required',
            // 'collected_on_sales' => 'required',
            // 'sales_rate' => 'required',
            // 'purchase_rate' => 'required',
            // 'collected_on_purchase' => 'required',
            //'amount' => 'required',
        ];

        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();

        try{
            $inputs = $request->except(['practice_id']);
            $charge = $this->productSalesCharge->findByUuid($uuid);
            $this->productSalesCharge->update($inputs,$charge->id);
            $inputs['start_period'] = date('Y-m-d H:i:s');//date('Y').'-'.$request->start_period.'-d H:i:s';
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
        $taxes = $this->productSalesCharge->findByUuid($uuid);
        $taxes->delete();
        $http_resp['description'] = "Deleted successful!";
        return response()->json($http_resp);

    }

}

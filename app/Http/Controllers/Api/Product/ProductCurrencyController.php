<?php

namespace App\Http\Controllers\Api\Product;

use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Models\Product\ProductCurrency;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductCurrencyController extends Controller
{
    protected $productCurrency;
    protected $practice;
    protected $http_response;
    protected $helper;

    public function __construct(ProductCurrency $productCurrency)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productCurrency = new ProductReposity($productCurrency);
        $this->practice = new PracticeRepository(new Practice());
    }

    public function index($practice_uuid=null){
        $http_resp = $this->http_response['200'];
        $results = array();
        if($practice_uuid){
            $practice = $this->practice->findByUuid($practice_uuid);
            $practiceParent = $this->practice->findParent($practice);
            $currencies = $practiceParent->product_currency()->orderByDesc('created_at')->paginate(10);
            $paged_data = $this->helper->paginator($currencies);
            foreach($currencies as $currenc){
                array_push($results,$this->productCurrency->transform_($currenc));
            }
            $paged_data['data'] = $results;
            $http_resp['results'] = $paged_data;
        }
        return response()->json($http_resp);
    }

    public function create(Request $request){
        $http_resp = $this->http_response['200'];
        $rules = [
            'name'=>'required',
            'slug'=>'required',
            'status'=>'required',
            'practice_id'=>'required',
        ];
        $validation = Validator::make($request->all(),$rules,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        DB::beginTransaction();
        try{
            $practice = $this->practice->findByUuid($request->practice_id);
            $practice = $this->practice->findOwner($practice);
            if (!$this->practice->setCurrency($practice,$request->all())){
                DB::rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ['Name already exists'];
                return response()->json($http_resp,422);
            }
            $http_resp['description'] = "Created successful!";
        }catch (\Exception $exception){
            Log::info($exception);
            DB::rollBack();
            $http_resp = $this->http_response['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }
    public function update(Request $request,$uuid){

        $http_resp = $this->http_response['200'];
        $currency = $this->productCurrency->findByUuid($uuid);
        $this->productCurrency->update($request->except(['practice_id']),$currency->id);
        $http_resp['description'] = "Updated successful!";
        return response()->json($http_resp);

    }
    public function show($uuid){}
    public function destroy($uuid){

        $http_resp = $this->http_response['200'];
        $currency = $this->productCurrency->findByUuid($uuid);
        $this->productCurrency->destroy($currency->id);
        $http_resp['description'] = "Deleted successful!";
        return response()->json($http_resp);

    }

}

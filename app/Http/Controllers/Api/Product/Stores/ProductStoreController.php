<?php

namespace App\Http\Controllers\Api\Product\Stores;

use App\Models\Supplier\Supplier;
use App\Repositories\Supplier\SupplierRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\helpers\HelperFunctions;
use Illuminate\Support\Facades\DB;
use App\Repositories\Practice\PracticeRepository;
use App\Models\Practice\Practice;
use App\Repositories\User\UserRepository;
use App\Models\Users\User;
use App\Repositories\Accounts\AccountingRepository;
use App\Models\Account\Vendors\AccountVendor;
use App\Models\Product\Store\ProductStore;
use App\Repositories\Product\ProductReposity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProductStoreController extends Controller
{
    protected $productStore;
    protected $http_response;
    protected $helper;
    protected $practice;

    public function __construct(ProductStore $productStore)
    {
        $this->productStore = new ProductReposity($productStore);
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practice = new PracticeRepository(new Practice());
    }

    public function index($practice_id = null,$store_type="Main"){
        $http_resp = $this->http_response['200'];
        $transactions = array();
        //Log::info($practice_id);
        if($practice_id){
            $practice = $this->practice->findByUuid($practice_id);
            $parentPractice = $this->practice->findParent($practice);
            $product_stores = $parentPractice->stores()->where('type',$store_type)->paginate(10);
            //Log::info($product_stores);
            $paged_data = $this->helper->paginator($product_stores);
            //Log::info($paged_data);
            foreach ($product_stores as $product_store) {
                array_push($transactions, $this->helper->transform_store($product_store));
            }
            $paged_data['data'] = $transactions;
            $http_resp['results'] = $paged_data;
        }
        //Log::info($practice);
        //Log::info($parentPractice);
        return response()->json($http_resp);
    }

    public function create(Request $request){

        $http_resp = $this->http_response['200'];
        $rules = [
            'practice_id'=>'required',
            'branch_id'=>'required',
            'name'=>'required',
            'type'=>'required',
            'code'=>'required|unique:product_stores',
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
            $parentPractice = $this->practice->findParent($practice);
            $product_stores = $practice->stores()->create($request->all());
            $product_stores = $parentPractice->stores()->save($product_stores);
            $http_resp['description'] = "Store added successful!";

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::rollBack();
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function update(Request $request, $uuid){

        $http_resp = $this->http_response['200'];
        Log::info($uuid);
        Log::info($request);

        DB::beginTransaction();

        try{

            $product_store = $this->productStore->findByUuid($uuid);
            Log::info($product_store);
            $product_store->update($request->all());
            $http_resp['description'] = "Successful updated";

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::rollBack();
            return response()->json($http_resp,500);
        }

        DB::commit();
        return response()->json($http_resp);

    }

}

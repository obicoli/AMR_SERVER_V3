<?php

namespace App\Http\Controllers\Api\Product\Stores;

//use App\Models\Supplier\Supplier;
//use App\Repositories\Supplier\SupplierRepository;
use App\Models\Module\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\helpers\HelperFunctions;
use Illuminate\Support\Facades\DB;
use App\Repositories\Practice\PracticeRepository;
use App\Models\Practice\Practice;
use App\Repositories\User\UserRepository;
use App\Models\Users\User;
//use App\Repositories\Accounts\AccountingRepository;
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

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $transactions = array();
        $company = $this->practice->find($request->user()->company_id);
        $warehouses = $company->productStores()->orderByDesc('created_at')->paginate(10);
        $paged_data = $this->helper->paginator($warehouses);
        foreach ( $warehouses as $warehouse ){
            array_push($paged_data['data'], $this->productStore->transform_store($warehouse));
        }
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function create(Request $request){

        $http_resp = $this->http_response['200'];
        $rules = [
            'name'=>'required',
            'email'=>'required',
            'mobile'=>'required',
            'status'=>'required',
        ];
        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        $company = $this->practice->find($request->user()->company_id);
        $encoded_mobile = $this->helper->encode_mobile($request->mobile);
        if( $company->productStores()->where('email',$request->email)->get()->first() ){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ['Email address already in use'];
            return response()->json($http_resp,422);
        }

        if( $company->productStores()->where('mobile',$encoded_mobile)->get()->first() ){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ['Mobile number already in use'];
            return response()->json($http_resp,422);
        }

        if( $company->productStores()->where('name',$request->name)->get()->first() ){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ['Name already in use'];
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        try{
            $inputs = $request->all();
            $inputs['mobile'] = $encoded_mobile;
            if($request->is_default){
                $product_stores = $company->productStores()->get();
                foreach ($product_stores as $product_store){
                    $product_store->update(['is_default'=>false]);
                }
            }
            $new_store = $company->productStores()->create($inputs);
            $http_resp['description'] = "Warehouse successful created!";
        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function update(Request $request, $uuid){
        $http_resp = $this->http_response['200'];
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        try{
            $company = $this->practice->find($request->user()->company_id);
            if($request->is_default){
                $product_stores = $company->productStores()->get();
                foreach ($product_stores as $product_store){
                    $product_store->update(['is_default'=>false]);
                }
            }
            $product_store = $this->productStore->findByUuid($uuid);
            $product_store->update($request->all());
            $http_resp['description'] = "Warehouse successful updated!";
        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function delete(Request $request, $uuid){
        $http_resp = $this->http_response['200'];
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        try {
            $product_store = $this->productStore->findByUuid($uuid);
            $product_store->delete();
            $http_resp['description'] = "Warehouse successful deleted!";
        }catch (\Exception $e){
            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        return response()->json($http_resp);
    }

}

<?php

namespace App\Http\Controllers\Api\Product;

use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Models\Product\ProductBrandSector;
use App\Models\Product\ProductCategory;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Models\Practice\PracticeProductItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    protected $productCategory;
    protected $http_response;
    protected $helper;
    protected $practice;
    protected $productItems;

    public function __construct(ProductCategory $productCategory)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productCategory = new ProductReposity($productCategory);
        $this->practice = new PracticeRepository(new Practice());
        $this->productItems = new ProductReposity(new PracticeProductItem());
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $company = $this->practice->find($request->user()->company_id);
        $headQuarter = $this->practice->findParent($company);
        $categories = $headQuarter->product_category()->orderByDesc('created_at')->paginate(12);
        $results = array();
        foreach($categories as $category){
            array_push($results,$this->productCategory->transform_attribute($category));
        }
        $paged_data = $this->helper->paginator($categories);
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    //practice
    // public function practice($practice_uuid){
    //     $http_resp = $this->http_response['200'];
    //     $practice = $this->practice->findByUuid($practice_uuid);
    //     $categories = $this->productCategory->getCategories($practice);
    //     $paged_data = $this->helper->paginator($categories);
    //     $paged_data['data'] = $this->productCategory->transform_collection($categories);
    //     $http_resp['results'] = $paged_data;
    //     return response()->json($http_resp);
    // }

    public function create(Request $request){

        $http_resp = $this->http_response['200'];
        $rules = [
            'name'=>'required',
            //'description'=>'required',
            //'practice_id'=>'required',
            'status'=>'required'
        ];
        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        $user = $request->user();
        $practice = $this->practice->find($user->company_id);
        $practiceParent = $this->practice->findParent($practice);
        if( $practiceParent->product_category()->where('name',$request->name)->get()->first() ){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ['Category name already taken!'];
            return response()->json($http_resp,422);
        }
        DB::beginTransaction();
        try{

            $practiceParent->product_category()->create($request->all());
            $http_resp['description']= "Created successful!";

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            DB::rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function update(Request $request,$uuid){
        $http_resp = $this->http_response['200'];
        $rules = [
            'name'=>'required',
            'description'=>'required',
            'status'=>'required'
        ];
        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        // $practice = $this->practice->findByUuid($request->practice_id);
        // $practiceParent = $this->practice->findParent($practice);
        DB::beginTransaction();
        try{

            $category = $this->productCategory->findByUuid($uuid);
            $category->update($request->all());
            $http_resp['description']= "Updated successful!";

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            DB::rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function show($uuid){
        $http_resp = $this->http_response['200'];
        $prodo = array();
        $category = $this->productCategory->findByUuid($uuid); //
        $products = $category->product_items()->get()->sortBy('created_at');
        foreach($products as $produc){
            array_push($prodo,$this->productItems->transform_product_item($produc,null,null,null));
        }
        $http_resp['results'] = $prodo;
        return response()->json($http_resp);
    }

    public function destroy($uuid){
        $http_resp = $this->http_response['200'];
        $category = $this->productCategory->findByUuid($uuid);
        $category->delete();
        $http_resp['description'] = "Deleted successful!";
        return response()->json($http_resp);
    }
}

<?php

namespace App\Http\Controllers\Api\Product;

use App\helpers\HelperFunctions;
use App\Models\Product\Product;
use App\Models\Product\ProductBrand;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Models\Product\Profile\ProductProfile;
use App\Repositories\Practice\PracticeRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductProfileController extends Controller
{
    //
    protected $productProfile;
    protected $http_response;
    protected $helper;
    protected $practice;
    protected $products;
    protected $company;

    public function __construct(ProductProfile $productProfile)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productProfile = new ProductReposity($productProfile);
        $this->practice = new PracticeRepository( new Practice() );
        $this->products = new ProductReposity(new Product());
        $this->company = new ProductReposity(new Manufacturer());
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $company = $this->practice->find($request->user()->company_id);
        $headQuarter = $this->practice->findParent($company);
        $categories = $headQuarter->product_profiles()->orderByDesc('created_at')->paginate(12);
        $results = array();
        foreach($categories as $category){
            array_push($results,$this->productProfile->transform_attribute($category));
        }
        $paged_data = $this->helper->paginator($categories);
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function create(Request $request){
        $http_resp = $this->http_response['200'];
        $rules = [
            'description' => 'required',
            'status' => 'required',
            'name' => 'required',
        ];
        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        //
        $user = $request->user();
        $practice = $this->practice->find($user->company_id);
        $practiceParent = $this->practice->findParent($practice);
        if($practiceParent->product_profiles()->where('name',$request->name)->get()->first() ){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ['Name already in use'];
            return response()->json($http_resp,422);
        }
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        try{
            $practiceParent->product_profiles()->create($request->all());
            $http_resp['description'] = "Created successful";
        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function update(Request $request,$uuid){
        $http_resp = $this->http_response['200'];
        $rules = [
            'name' => 'required',
            'status' => 'required',
            'description' => 'required',
        ];
        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        try{
            $profile = $this->productProfile->findByUuid($uuid);
            $profile->update($request->all());
            $http_resp['descrption']="Updated successful";
        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function destroy($uuid){
        $http_resp = $this->http_response['200'];
        $brand = $this->productProfile->findByUuid($uuid);
        $brand->delete();
        $http_resp['description'] = "Deleted successful";
        return response()->json($http_resp);
    }

}

<?php

namespace App\Http\Controllers\Api\Product;

use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Models\Product\Product;
use App\Models\Product\ProductBrandSector;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Module\Module;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductBrandSectorController extends Controller
{
    protected $productBrandSector;
    protected $practice;
    protected $http_response;
    protected $helper;

    public function __construct(ProductBrandSector $productBrandSector)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productBrandSector = new ProductReposity($productBrandSector);
        $this->practice = new PracticeRepository( new Practice());
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $company = $this->practice->find($request->user()->company_id);
        $headQuarter = $this->practice->findParent($company);
        $categories = $headQuarter->product_brand_sector()->orderByDesc('created_at')->paginate(12);
        $results = array();
        foreach($categories as $category){
            array_push($results,$this->productBrandSector->transform_attribute($category));
        }
        $paged_data = $this->helper->paginator($categories);
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function create(Request $request){
        $http_resp = $this->http_response['200'];
        $rules = [
            'name'=>'required',
            'status'=>'required',
            'description'=>'required',
        ];
        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        $user = $request->user();
        $practice = $this->practice->find($user->company_id);
        $practiceParent = $this->practice->findParent($practice);
        if ($practiceParent->product_brand_sector()->where('name',$request->name)->get()->first()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ['Name already exists'];
            return response()->json($http_resp,422);
        }
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        try{
            $practiceParent->product_brand_sector()->create($request->all());
            $http_resp['description'] = "Created successful!";
        }catch (\Exception $e){
            Log::info($e);
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            $http_resp = $this->http_response['500'];
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function update(Request $request,$uuid){

        $http_resp = $this->http_response['200'];
        $rules = [
            'name'=>'required',
            'status'=>'required',
            'description'=>'required',
        ];
        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        try{
            $brandsector = $this->productBrandSector->findByUuid($uuid);
            $this->productBrandSector->update($request->all(),$brandsector->id);
            $http_resp['description'] = "Successful updated!";
        }catch (\Exception $e){
            Log::info($e);
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            $http_resp = $this->http_response['500'];
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function show($uuid){

    }

    public function destroy($uuid){
        $http_resp = $this->http_response['200'];
        $brandsector = $this->productBrandSector->findByUuid($uuid);
        $this->productBrandSector->destroy($brandsector->id);
        $http_resp['description'] = "Deleted successful!";
        return response()->json($http_resp);
    }

}

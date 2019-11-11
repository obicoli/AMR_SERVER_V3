<?php

namespace App\Http\Controllers\Api\Product;

use App\helpers\HelperFunctions;
use App\Models\Product\Product;
use App\Models\Product\ProductBrand;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Practice\Practice;
use App\Repositories\Practice\PracticeRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductBrandController extends Controller
{
    protected $productBrand;
    protected $http_response;
    protected $helper;
    protected $practice;
    protected $products;
    protected $company;

    public function __construct(ProductBrand $productBrand)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productBrand = new ProductReposity($productBrand);
        $this->practice = new PracticeRepository( new Practice() );
        $this->products = new ProductReposity(new Product());
        $this->company = new ProductReposity(new Manufacturer());
    }

    public function index($practice_id=null){
        $http_resp = $this->http_response['200'];
        $results = array();
        if($practice_id){
            $practice = $this->practice->findByUuid($practice_id);
            $parentPractice = $this->practice->findParent($practice);
            $brands = $parentPractice->product_brands()->orderByDesc('created_at')->paginate(10);
            $paged_data = $this->helper->paginator($brands);
            foreach($brands as $brand){
                $temp_brand = $this->products->transform_($brand);
                $compani = $this->company->find($brand->company_id);
                if($compani){ $temp_brand['company_name'] = $compani->name; }
                array_push($results, $temp_brand);
            }
            $paged_data['data'] = $results;
        }else{

        }
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function store(Request $request){

        $http_resp = $this->http_response['200'];

        $rules = [
            'company_name' => 'required',
            'practice_id' => 'required',
            'name' => 'required',
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
            if($parentPractice->product_brands()->where('name',$request->name)->get()->first() ){
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ['Brand name already in use'];
                return response()->json($http_resp,422);
            }else{
                $company = $this->company->getOrCreate($request->company_name);
                $inputs = $request->all();
                $inputs['company_id'] = $company->id;
                $parentPractice->product_brands()->create($inputs);
            }
            $http_resp['description'] = "Created successful";
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
            'company_name' => 'required',
            'practice_id' => 'required',
            'name' => 'required',
        ];
        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        try{
            $practice = $this->practice->findByUuid($request->practice_id);
            $parentPractice = $this->practice->findParent($practice);
            $brand = $this->productBrand->findByUuid($uuid);
            $company = $this->company->getOrCreate($request->company_name);
            $inputs = $request->except(['company_name','practice_id']);
            $inputs['company_id'] = $company->id;
            $brand->update($inputs);
            $http_resp['descrption']="Updated successful";
        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            DB::rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }

        DB::commit();
        return response()->json($http_resp);

    }

    public function show($uuid){}
    public function destroy($uuid){
        $http_resp = $this->http_response['200'];
        $brand = $this->productBrand->findByUuid($uuid);
        $brand->delete();
        $http_resp['description'] = "Deleted successful";
        return response()->json($http_resp);
    }
}

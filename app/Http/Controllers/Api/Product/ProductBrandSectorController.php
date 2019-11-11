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

    public function index($practice_uuid=null){
        $http_resp = $this->http_response['200'];
        $results = array();
        if($practice_uuid){
            $practice = $this->practice->findByUuid($practice_uuid);
            $parentPractice = $this->practice->findParent($practice);
            $brands = $parentPractice->product_brand_sector()->orderByDesc('created_at')->paginate(10);
            $paged_data = $this->helper->paginator($brands);
            foreach($brands as $brand){
                array_push($results, $this->productBrandSector->transform_($brand));
            }
            $paged_data['data'] = $results;
        }else{
        }
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function create(Request $request){
        $http_resp = $this->http_response['200'];
        $rules = [
            'name'=>'required',
            'status'=>'required',
            'description'=>'required',
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
            $practice = $this->practice->findByUuid($request->practice_id);
            $practiceParent = $this->practice->findParent($practice);
            //$practice = $this->practice->findOwner($practice);
            if ($practiceParent->product_brand_sector()->where('name',$request->name)->get()->first()){
                DB::rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ['Name already exists'];
                return response()->json($http_resp,422);
            }else{
                $practiceParent->product_brand_sector()->create($request->all());
                $http_resp['description'] = "Created successful!";
            }
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
        $rules = [
            'name'=>'required',
            'status'=>'required',
            'practice_id'=>'required',
        ];
        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        $brandsector = $this->productBrandSector->findByUuid($uuid);
        $this->productBrandSector->update($request->all(),$brandsector->id);
        $http_resp['description'] = "Changes saved successful!";
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

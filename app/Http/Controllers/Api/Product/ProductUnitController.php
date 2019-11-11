<?php

namespace App\Http\Controllers\Api\Product;

use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Models\Product\ProductType;
use App\Models\Product\ProductUnit;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductUnitController extends Controller
{
    protected $productUnit;
    protected $practice;
    protected $http_response;
    protected $helper;

    public function __construct(ProductUnit $productUnit)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productUnit = new ProductReposity($productUnit);
        $this->practice = new PracticeRepository(new Practice());
    }

    public function index($practice_uuid=null){
        $results = array();
        if($practice_uuid){
            $http_resp = $this->http_response['200'];
            $practice = $this->practice->findByUuid($practice_uuid);
            $practicePractice = $this->practice->findParent($practice);
            $units = $practicePractice->product_units()->orderByDesc('created_at')->paginate(10);
            $paged_data = $this->helper->paginator($units);
            foreach( $units as $unit ){
                array_push($results,$this->productUnit->transform_($unit));
            }
            $paged_data['data'] = $results;
            $http_resp['results'] = $paged_data;
        }else{
        }
        return response()->json($http_resp);
    }

    public function create(Request $request){
        $http_resp = $this->http_response['200'];
        $rules = [
            'name'=>'required',
            'slug'=>'required',
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
            if ( $practiceParent->product_units()->where('name',$request->name)->get()->first() ){
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ['Name already exists'];
                return response()->json($http_resp,422);
            }else{
                $practiceParent->product_units()->create($request->all());
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
        $rules = [
            'name'=>'required',
            'slug'=>'required',
            'practice_id'=>'required',
        ];
        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        DB::beginTransaction();
        try{
            $product_unit = $this->productUnit->findByUuid($uuid);
            $product_unit->update($request->all());
            $http_resp['description'] = "Updated successful!";
        }catch (\Exception $exception){
            Log::info($exception);
            DB::rollBack();
            $http_resp = $this->http_response['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);

    }
    public function show($uuid){}
    public function destroy($uuid){
        $http_resp = $this->http_response['200'];
        $productUnit = $this->productUnit->findByUuid($uuid);
        $this->productUnit->destroy($productUnit->id);
        $http_resp['description'] = "Deleted successful!";
        return response()->json($http_resp);
    }
}

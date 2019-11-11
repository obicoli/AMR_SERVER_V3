<?php

namespace App\Http\Controllers\Api\Practice\Inventory;

use App\helpers\HelperFunctions;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeProductBrand;
use App\Models\Product\ProductBrand;
use App\Repositories\ModelRepository;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PracticeProductBrandController extends Controller
{
    protected $practiceProductBrand;
    protected $productBrand;
    protected $manufacturer;
    protected $practice;
    protected $practiceManufacturer;
    protected $response_type;
    protected $helper;

    public function __construct(ProductBrand $productBrand)
    {
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productBrand = new ProductReposity($productBrand);
        $this->manufacturer = new ProductReposity(new Manufacturer());
        $this->practice = new PracticeRepository(new Practice());
    }

    public function index(){}
    public function create(Request $request){

        $http_resp = $this->response_type['200'];
        $rules = [
            'name' => 'required',
            'practice_id' => 'required',
            'company_name' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ( $validator->fails() ){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validator->errors());
            return response()->json($http_resp,422);
        }
        DB::beginTransaction();
        try{

            $practice = $this->practice->findByUuid($request->practice_id);
            $practice = $this->practice->findOwner($practice);

            //$practiceManufacturer = $this->practiceManufacturer->findByUuid($request->company_id);
            $manufacturer = $this->manufacturer->findByName($request->company_name);
            $inputs = $request->except(['company_name']);
            $inputs['company_id'] = $manufacturer->id;
            if ($this->practice->setBrand($practice, $inputs)){
                $http_resp['description'] = "Created successful";
            }else{
                DB::rollBack();
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = ['Brand name already exist'];
                return response()->json($http_resp,422);
            }

        }catch (\Exception $exception){
            Log::info($exception);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);

    }
    public function update(Request $request,$uuid){
        $http_resp = $this->response_type['200'];
        $rules = [
            'name' => 'required',
            'practice_id' => 'required',
            'company_name' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ( $validator->fails() ){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validator->errors());
            return response()->json($http_resp,422);
        }
        DB::beginTransaction();
        try{
            $practice = $this->practice->findByUuid($request->practice_id);
            $practice = $this->practice->findOwner($practice);
            //$practiceManufacturer = $this->practiceManufacturer->findByUuid($request->company_id);
            $brand = $this->productBrand->findByUuid($uuid);
            $manufacturer = $this->manufacturer->findByName($request->company_name);
            $inputs = $request->except(['company_name']);
            $inputs['company_id'] = $manufacturer->id;
            if ($this->productBrand->update($inputs, $brand->id)){
                $http_resp['description'] = "Changes saved successful!";
            }else{
                DB::rollBack();
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = ['Brand name already exist'];
                return response()->json($http_resp,422);
            }
        }catch (\Exception $exception){
            Log::info($exception);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }
    public function show($uuid){}
    public function delete($uuid){
        $http_resp = $this->response_type['200'];
        $http_resp['description'] = "Deletion successful!";
        $brand = $this->productBrand->findByUuid($uuid);
        $this->productBrand->destroy($brand->id);
        return response()->json($http_resp);
    }

}

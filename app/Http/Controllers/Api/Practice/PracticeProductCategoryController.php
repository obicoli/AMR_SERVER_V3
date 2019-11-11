<?php

namespace App\Http\Controllers\Api\Practice;

use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductPracticeCategory;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class PracticeProductCategoryController extends Controller
{
    protected $response_type;
    protected $helper;
    protected $practice;
    protected $productCategory;

    public function __construct(Practice $practice)
    {
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practice = new PracticeRepository(new Practice());
        $this->productCategory = new ProductReposity(new ProductCategory());
    }

    public function index(Request $request){}
    public function delete(Request $request, $uuid){
        $http_resp = $this->response_type['200'];
        DB::beginTransaction();
        try{
            $product_pract_category = $this->productCategory->findByUuid($uuid);
            $this->productCategory->destroy($product_pract_category->id);
        }catch (\Exception $exception){
            Log::info($exception);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);

    }
    public function update(Request $request, $uuid){
        $http_resp = $this->response_type['200'];
        $rules = [
            'name' => 'required',
            'description' => 'required',
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

            $product_pract_category = $this->productCategory->findByUuid($uuid);
            $this->productCategory->update($request->except(['practice_id']), $product_pract_category->id);

        }catch (\Exception $exception){
            Log::info($exception);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);

    }
    public function create(Request $request){
        $http_resp = $this->response_type['200'];
        $rules = [
            'name' => 'required',
            'practice_id' => 'required',
            'description' => 'required',
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
            if ( !$this->practice->setProductCategory($practice, $request->all()) ){
                DB::rollBack();
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = ['Category name already exist'];
                return response()->json($http_resp,422);
            }else{
                $http_resp['description'] = "Created successful";
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
}

<?php

namespace App\Http\Controllers\Api\Product\Formulation;

use App\helpers\HelperFunctions;
use App\Models\Product\Accounts\ProductAccountType;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use Illuminate\Support\Facades\Config;
use App\Models\Product\ProductFormulation;
use App\Repositories\Practice\PracticeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FormulationController extends Controller
{
    protected $productFormulation;
    protected $http_response;
    protected $helper;

    public function __construct(ProductFormulation $productFormulation)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productFormulation = new ProductReposity($productFormulation);
        $this->practice = new PracticeRepository( new Practice() );
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $company = $this->practice->find($request->user()->company_id);
        $headQuarter = $this->practice->findParent($company);
        $categories = $headQuarter->product_formulations()->orderByDesc('created_at')->paginate(12);
        $results = array();
        foreach($categories as $category){
            array_push($results,$this->productFormulation->transform_attribute($category));
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
        if($practiceParent->product_formulations()->where('name',$request->name)->get()->first() ){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ['Name already in use'];
            return response()->json($http_resp,422);
        }
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        try{
            $practiceParent->product_formulations()->create($request->all());
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
            $brand = $this->productFormulation->findByUuid($uuid);
            $brand->update($request->all());
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

    public function show($uuid){}
    public function destroy($uuid){
        $http_resp = $this->http_response['200'];
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        try{
            $brand = $this->productFormulation->findByUuid($uuid);
            $brand->delete();
            $http_resp['description'] = "Deleted successful";
        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        return response()->json($http_resp);
    }

}

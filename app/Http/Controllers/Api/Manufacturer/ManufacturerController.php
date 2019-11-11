<?php

namespace App\Http\Controllers\Api\Manufacturer;

use App\helpers\HelperFunctions;
use App\Models\Manufacturer\Manufacturer;
use App\Repositories\Manufacturer\ManufacturerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ManufacturerController extends Controller
{
    protected $manufacturer;
    protected $helper;
    protected $response_type;

    public function __construct(Manufacturer $manufacturer)
    {
        $this->manufacturer = new ManufacturerRepository($manufacturer);
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function index(){
        $http_resp = $this->response_type['200'];
        $manufacturers = $this->manufacturer->all();
        $http_resp['results'] = $this->manufacturer->transform_collection($manufacturers);
        return response()->json($http_resp);
    }
    public function show($uuid){}
    public function store(Request $request){

        $http_resp = $this->response_type['200'];
        $rules = [
            'name'=>'required|unique:manufacturers'
        ];
        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        DB::beginTransaction();
        try{
            $manufacturer = $this->manufacturer->store($request->all());
            $http_resp['results'] = $this->manufacturer->transform_($manufacturer);
        }catch (\Exception $exception){
            Log::info($exception);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);

    }
    public function update(Request $request, $uuid){}
    public function destroy($uuid){}

}

<?php

namespace App\Http\Controllers\Api\Addresses;

use App\helpers\HelperFunctions;
use App\Models\Addresses\DeliveryAddress;
use App\Repositories\Address\AddressRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DeliveryAddressController extends Controller
{
    protected $deliveryAddress;
    protected $response_type;
    protected $helper;

    public function __construct(DeliveryAddress $deliveryAddress)
    {
        $this->deliveryAddress = new AddressRepository($deliveryAddress);
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function index(Request $request){

        $http_resp = $this->response_type['200'];
        $user = $request->user();
        $addresses = $this->deliveryAddress->getByUser($user);
        $results = array();
        foreach ($addresses as $address){
            $temp_data['id'] = $address->uuid;
            $temp_data['phone'] = $address->phone;
            $temp_data['area'] = $address->area;
            $temp_data['region'] = $address->region;
            $temp_data['street'] = $address->street;
            $temp_data['estate_landmark_buildings'] = $address->estate_landmark_buildings;
            array_push($results, $temp_data);
        }
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }
    public function store(Request $request){

        $http_resp = $this->response_type['200'];
        $rule = [
            'region' => 'required',
            'area' => 'required',
            'street' => 'required',
            'phone' => 'required',
            'estate_landmark_buildings' => 'required',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validate->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{

            $user = $request->user();
            $user->delivery_address()->create($request->all());

        }catch (\Exception $e){
            Log::info($e);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }

        DB::commit();
        return response()->json($http_resp);

    }
    public function update(Request $request, $uuid){
        $http_resp = $this->response_type['200'];
        $rule = [
            'region' => 'required',
            'area' => 'required',
            'street' => 'required',
            'phone' => 'required',
            'estate_landmark_buildings' => 'required',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validate->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{

            $this->deliveryAddress->updateByUuid($request->all(), $uuid);

        }catch (\Exception $e){
            Log::info($e);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }

        DB::commit();
        return response()->json($http_resp);
    }
    public function show($uuid){}
    public function destroy($uuid){
        $http_resp = $this->response_type['200'];
        $this->deliveryAddress->deleteByUuid($uuid);
        return response()->json($http_resp);
    }

}

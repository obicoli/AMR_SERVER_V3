<?php

namespace App\Http\Controllers\Api\Product\Accounts;

use App\helpers\HelperFunctions;
use App\Models\Product\Accounts\ProductAccountType;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class ProductAccountTypeController extends Controller
{
    protected $productAccountType;
    protected $http_response;
    protected $helper;

    public function __construct(ProductAccountType $productAccountType)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productAccountType = new ProductReposity($productAccountType);
    }

    public function index(){

        $http_resp = $this->http_response['200'];
        $results = array();
        $account_types = $this->productAccountType->all()->sortBy('name');
        //Log::info($account_types);
        foreach ($account_types as $account_type){
            $temp_data['id'] = $account_type->uuid;
            $temp_data['name'] = $account_type->name;
            $account_details = $account_type->detail_type()->get()->sortBy('name');
            $result = array();
            foreach ($account_details as $account_detail){
                $temp1['id'] = $account_detail->uuid;
                $temp1['name'] = $account_detail->name;
                array_push($result,$temp1);
            }
            $temp_data['account_details_type'] = $result;
            array_push($results,$temp_data);
        }
        Log::info($results);
        $http_resp['results'] = $results;
        return response()->json($http_resp,200);

    }
    public function store(Request $request){}
    public function update(Request $request,$uuid){}
    public function show($uuid){}
    public function destroy($uuid){}
}

<?php

namespace App\Http\Controllers\Api\Product\Accounts;

use App\helpers\HelperFunctions;
use App\Http\Controllers\Controller;
use App\Models\Product\Accounts\AccountNature;
use App\Models\Product\Accounts\AccountType;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ChartAccountsTypeController extends Controller
{
    protected $accountType;
    protected $http_response;
    protected $helper;

    public function __construct(AccountType $accountType)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->accountType = new ProductReposity($accountType);
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $product_types = $this->accountType->all();
        $http_resp['results'] = $this->accountType->transform_collection($product_types);
        return response()->json($http_resp);
    }

    public function store(Request $request){}
    public function update(Request $request,$uuid){}
    public function show($uuid){}
    public function destroy($uuid){}
}

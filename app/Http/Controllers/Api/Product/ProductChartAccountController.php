<?php

namespace App\Http\Controllers\Api\Product;

use App\helpers\HelperFunctions;
use App\Models\Product\Accounts\ProductChartAccount;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class ProductChartAccountController extends Controller
{
    protected $productChartAccount;
    protected $http_response;
    protected $helper;

    public function __construct(ProductChartAccount $productChartAccount)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productChartAccount = new ProductReposity($productChartAccount);
    }

    public function index(Request $request){}
    public function store(Request $request){}
    public function update(Request $request,$uuid){}
    public function show($uuid){}
    public function destroy($uuid){}

}

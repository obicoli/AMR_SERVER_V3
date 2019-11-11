<?php

namespace App\Http\Controllers\Api\Product;

use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductType;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class ProductTypeController extends Controller
{
    protected $productType;
    protected $http_response;
    protected $helper;
    protected $practice;

    public function __construct(ProductType $productType)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productType = new ProductReposity($productType);
        $this->practice = new PracticeRepository(new Practice());
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $product_types = $this->productType->all();
        $http_resp['results'] = $this->productType->transform_collection($product_types);
        return response()->json($http_resp);
    }

    public function practice($practice_uuid){
        $http_resp = $this->http_response['200'];
        $practice = $this->practice->findByUuid($practice_uuid);
        $categories = $this->productType->getTypes($practice);
        $http_resp['results'] = $this->productType->transform_collection($categories);
        return response()->json($http_resp);
    }

    public function store(Request $request){}
    public function update(Request $request,$uuid){}
    public function show($uuid){}
    public function destroy($uuid){}
}

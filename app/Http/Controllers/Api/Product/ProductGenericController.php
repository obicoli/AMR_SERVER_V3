<?php

namespace App\Http\Controllers\Api\Product;

use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Models\Product\ProductBrandSector;
use App\Models\Product\ProductCategory;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Models\Product\ProductGeneric;

class ProductGenericController extends Controller
{
    protected $productGeneric;
    protected $http_response;
    protected $helper;
    protected $practice;

    public function __construct(ProductGeneric $productGeneric)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productGeneric = new ProductReposity($productGeneric);
        $this->practice = new PracticeRepository(new Practice());
    }

    public function index(Request $request){

    }
    //practice
    public function practice($practice_uuid){
        $http_resp = $this->http_response['200'];
        $practice = $this->practice->findByUuid($practice_uuid);
        $generics = $this->productGeneric->getGenerics($practice);
        $http_resp['results'] = $this->productGeneric->transform_collection($generics);
        return response()->json($http_resp);
    }

    public function create(Request $request){

    }
    public function update(Request $request,$uuid){}
    public function show($uuid){}
    public function destroy($uuid){}

}

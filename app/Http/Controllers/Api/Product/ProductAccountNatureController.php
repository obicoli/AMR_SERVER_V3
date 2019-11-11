<?php

namespace App\Http\Controllers\Api\Product;

use App\helpers\HelperFunctions;
use App\Models\Product\Accounts\ProductAccountNature;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class ProductAccountNatureController extends Controller
{
    protected $productAccountNature;
    protected $http_response;
    protected $helper;

    public function __construct(ProductAccountNature $productAccountNature)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productAccountNature = new ProductReposity($productAccountNature);
    }

    public function index(Request $request){}
    public function store(Request $request){}
    public function update(Request $request,$uuid){}
    public function show($uuid){}
    public function destroy($uuid){}
}

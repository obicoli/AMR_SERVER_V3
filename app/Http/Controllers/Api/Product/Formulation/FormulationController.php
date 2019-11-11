<?php

namespace App\Http\Controllers\Api\Product\Formulation;

use App\helpers\HelperFunctions;
use App\Models\Product\Accounts\ProductAccountType;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Models\Product\ProductFormulation;

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
    }

    public function index(){}
    public function store(Request $request){}
    public function show($uuid){}
    public function destroy($uuid){}
    public function update(Request $request,$uuid){}

}

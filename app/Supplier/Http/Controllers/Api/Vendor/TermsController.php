<?php

namespace App\Supplier\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Repositories\Practice\PracticeRepository;
use App\Supplier\Models\SupplierTerms;
use App\Supplier\Repositories\SupplierRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    protected $supplierTerms;
    protected $http_response;
    protected $practices;
    protected $helper;

    public function __construct( SupplierTerms $supplierTerms )
    {
        $this->supplierTerms = new SupplierRepository($supplierTerms);
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice());
    }

    public function index(Request $request){

        $http_resp = $this->http_response['200'];
        $results = array();
        $company = $this->practices->find($request->user()->company_id);
        $supplier_terms = $company->supplier_terms()->get();
        foreach($supplier_terms as $supplier_term){
            array_push($results,$this->supplierTerms->transform_term($supplier_term) );
        }
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }

}

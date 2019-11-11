<?php

namespace App\Supplier\Http\Controllers\Api\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Practice\Practice;
use Illuminate\Support\Facades\Config;
use App\Repositories\Practice\PracticeRepository;
use App\Supplier\Repositories\SupplierRepository;
use Illuminate\Support\Facades\Validator;
use App\helpers\HelperFunctions;
use App\Supplier\Models\SupplierCompany;

class CompanyController extends Controller
{
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $supplierCompany;

    public function __construct(SupplierCompany $supplierCompany)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice() );
        $this->supplierCompany = new SupplierRepository( $supplierCompany );
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $results = array();
        $company = $this->practices->find($request->user()->company_id);
        $companies = $company->product_suppliers()->orderByDesc('created_at')->paginate(20);
        $paged_data = $this->helper->paginator($companies);
        foreach( $companies as $company){
            array_push($results, $this->supplierCompany->transform_company($company) );
        }
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

}

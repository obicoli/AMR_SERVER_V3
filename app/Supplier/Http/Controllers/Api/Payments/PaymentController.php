<?php

namespace App\Supplier\Http\Controllers\Api\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Supplier\Models\SupplierPayment;
use Illuminate\Support\Facades\Config;
use App\helpers\HelperFunctions;
use App\Repositories\Practice\PracticeRepository;
use App\Models\Practice\Practice;
use App\Supplier\Repositories\SupplierRepository;

class PaymentController extends Controller
{
    protected $supplierPayment;
    protected $http_response;
    protected $practices;
    protected $helper;

    public function __construct( SupplierPayment $supplierPayment ){

        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice() );
        $this->supplierPayment = new SupplierRepository($supplierPayment);
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $user = $request->user();
        $results = array();
        $company = $this->practices->find($user->company_id);
        $payments = $company->supplier_payments()->orderByDesc('created_at')->paginate(10);
        foreach($payments as $payment){
            array_push($results,$this->supplierPayment->transform_payment($payment));
        }
        $paged_data = $this->helper->paginator($payments);
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }
}

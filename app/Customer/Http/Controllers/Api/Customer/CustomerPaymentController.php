<?php

namespace App\Customer\Http\Controllers\Api\Customer;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\Payments\AccountPaymentType;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Accounting\Repositories\AccountingRepository;
use App\Customer\Models\Customer;
use App\Customer\Models\CustomerPayment;
use App\Customer\Models\CustomerTerms;
use App\Customer\Repositories\CustomerRepository;
use App\Http\Controllers\Controller;
use App\helpers\HelperFunctions;
use App\Models\Account\Account;
use App\Models\Localization\Country;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Models\Product\ProductTaxation;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CustomerPaymentController extends Controller
{
    //
    protected $customerPayment;
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $countries;
    protected $customer_terms;
    protected $payment_methods;
    protected $accountingVouchers;
    protected $taxations;
    protected $accountChartAccount;

    public function __construct( CustomerPayment $customerPayment )
    {
        $this->customerPayment = new CustomerRepository($customerPayment);
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice());
        $this->customer_terms = new CustomerRepository(new CustomerTerms());
        $this->payment_methods = new AccountingRepository(new AccountPaymentType());
        $this->accountingVouchers = new AccountingRepository(new AccountsVoucher());
        $this->countries = new AccountingRepository( new Country() );
        $this->taxations = new ProductReposity( new ProductTaxation() );
        $this->accountChartAccount = new AccountingRepository(new AccountChartAccount());
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $results = array();
        $company = $this->practices->find($request->user()->company_id);
        $customerpayments = $company->customer_payments()->orderByDesc('created_at')->paginate(10);
        $paged_data = $this->helper->paginator($customerpayments);
        foreach($customerpayments as $customerpayment){
            array_push($results,$this->customerPayment->transform_payment($customerpayment));
        }
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

}

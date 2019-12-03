<?php

namespace App\Customer\Http\Controllers\Api\Customer;

use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\Payments\AccountPaymentType;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Accounting\Repositories\AccountingRepository;
use App\Customer\Models\Customer;
use App\Customer\Models\CustomerTerms;
use App\Customer\Repositories\CustomerRepository;
use App\Http\Controllers\Controller;
use App\helpers\HelperFunctions;
use App\Models\Account\Account;
use App\Models\Localization\Country;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Repositories\Practice\PracticeRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TermsController extends Controller
{
    protected $customerTerms;
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $countries;
    protected $customer_terms;
    protected $payment_methods;
    protected $accountingVouchers;

    public function __construct( CustomerTerms $customerTerms )
    {
        $this->customerTerms = new CustomerRepository($customerTerms);
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice());
        //$this->customers = new CustomerRepository($customers);
        //$this->customer_terms = new CustomerRepository(new CustomerTerms());
        // $this->payment_methods = new AccountingRepository(new AccountPaymentType());
        // $this->accountingVouchers = new AccountingRepository(new AccountsVoucher());
        // $this->countries = new AccountingRepository( new Country() );
    }

    public function index(Request $request){

        $http_resp = $this->http_response['200'];
        $results = array();
        $company = $this->practices->find($request->user()->company_id);
        $customers = $company->customer_terms()->get();
        foreach($customers as $customer){
            array_push($results,$this->customerTerms->transform_term($customer) );
        }
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }

}

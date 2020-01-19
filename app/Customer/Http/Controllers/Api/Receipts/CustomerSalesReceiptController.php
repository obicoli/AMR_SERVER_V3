<?php

namespace App\Customer\Http\Controllers\Api\Receipts;

use App\Accounting\Models\COA\AccountsCoa;
use App\Customer\Models\Customer;
use App\Customer\Models\Orders\CustomerSalesOrder;
use App\Customer\Models\Quote\Estimate;
use App\Customer\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use Illuminate\Support\Facades\Config;
use App\Repositories\Practice\PracticeRepository;
use App\Models\Module\Module;
use App\Models\NotificationCenter\MailBox;
use App\Models\Practice\PracticeUser;
use App\Models\Product\Product;
use App\Models\Product\ProductItem;
use App\Models\Product\ProductTaxation;
use App\Repositories\Product\ProductReposity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Product\Sales\ProductPriceRecord;
use App\Customer\Models\CustomerTerms;
use App\Customer\Models\Invoice\CustomerInvoice;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Accounting\Repositories\AccountingRepository;
use App\Customer\Models\Sales\CustomerSalesReceipt;
use App\Finance\Models\Banks\AccountsBank;
use App\Finance\Models\Banks\BankTransaction;
use App\Finance\Repositories\FinanceRepository;

class CustomerSalesReceiptController extends Controller
{
    protected $estimates;
    protected $customerSalesReceipt;
    protected $customerSalesOrder;
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $customers;
    protected $company_users;
    protected $productItems;
    protected $product_pricing;
    protected $productTaxations;
    protected $customerTerms;
    protected $accountDoubleEntries;
    protected $bankAccounts;
    protected $bankTransactions;

    public function __construct(CustomerSalesReceipt $customerSalesReceipt)
    {
        $this->customerSalesReceipt = new CustomerRepository($customerSalesReceipt);
        $this->estimates = new CustomerRepository( new Estimate() );
        $this->customerSalesOrder = new CustomerRepository( new CustomerSalesOrder() );
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice() );
        $this->customers = new CustomerRepository(new Customer());
        $this->company_users = new PracticeRepository(new PracticeUser());
        $this->productItems = new ProductReposity(new ProductItem());
        $this->product_pricing = new ProductReposity(new ProductPriceRecord());
        $this->productTaxations = new ProductReposity( new ProductTaxation() );
        $this->customerTerms = new CustomerRepository( new CustomerTerms() );
        $this->accountDoubleEntries = new AccountingRepository( new AccountsVoucher() );
        $this->bankAccounts = new FinanceRepository( new AccountsBank());
        $this->bankTransactions = new FinanceRepository( new BankTransaction() );
    }

    public function index(Request $request){

        $http_resp = $this->http_response['200'];
        $results = array();
        $company = $this->practices->find($request->user()->company_id); //Get the company
        if($request->has('unpaid_customer_invoice')){
            $partial_paid_status = Product::STATUS_PARTIAL_PAID;
            $unpaid_status = Product::STATUS_UNPAID;
            $customer = $this->customers->findByUuid($request->unpaid_customer_invoice);
            $salesreceipts = $customer->salesReceipts()
                ->where('status',$partial_paid_status)
                ->orWhere('status',$unpaid_status)
                ->orderByDesc('created_at')
                ->paginate(100);
        }else{
            $salesreceipts = $company->salesReceipts()->orderByDesc('created_at')->paginate(10);
        }
        
        $paged_data = $this->helper->paginator($salesreceipts);
        foreach($salesreceipts as $salesreceipt){
            array_push($results,$this->customerSalesOrder->transform_sales_receipt($salesreceipt));
        }
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }
}

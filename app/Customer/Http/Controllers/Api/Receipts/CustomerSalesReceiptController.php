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
use App\Customer\Models\Sales\CustomerSalesReceiptItemTaxation;
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

    public function create(Request $request){

        $inputs = $request->all();
        $http_resp = $this->http_response['200'];
        $rule = [
            //'customer_id'=>'required',
            'action_taken'=>'required',
            'overal_discount'=>'required',
            'notes'=>'required',
            'net_total'=>'required',
            'items'=>'required',
            'trans_date'=>'required',
            //'due_date'=>'required',
            'terms_condition'=>'required',
            //'sales_basis'=>'required',
            //'invoice_type'=>'required',
        ];
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        $rule2 = [
            'cash_paid'=>'required',
            'cash_balance'=>'required',
            'bank_account_id'=>'required',
            'cheque_number'=>'required',
        ];
        $validation = Validator::make($request->payment,$rule2,$this->helper->messages());
        if ( $validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try{

            $sales_ac_code = AccountsCoa::AC_SALES_CODE;
            $disc_allowed_code = AccountsCoa::AC_DISCOUNT_ALLOWED_CODE;
            $as_at = $this->helper->format_lunox_date($inputs['trans_date']);
            //$inputs['due_date'] = $this->helper->format_lunox_date($inputs['due_date']);
            $inputs['trans_date'] = $as_at;
            $company = $this->practices->find($request->user()->company_id); //Get the company
            $practiceParent = $this->practices->findParent($company);
            $finance_settings = $company->practice_finance_settings()->get()->first(); //
            //$invoice_prefix = $finance_settings->inv_prefix;
            $sales_receipt_prefix = "SRT-";
            $company_user = $this->company_users->find($request->user()->company_id); //Get current user
            $customer = $this->customers->findByUuid($request->customer_id);
            //$invoice_basis_type = $request->sales_basis;
            //$cash_basis_invoice = AccountsCoa::CASH;
            //$unpaid_status = Product::STATUS_UNPAID;
            //$active_status = Product::STATUS_ACTIVE;
            $bank_account = $this->bankAccounts->findByUuid($request->payment['bank_account_id']);
            $bank_ledger_ac_received = $bank_account->ledger_accounts()->get()->first();
            $ledger_support_document = null;
            $discount_allowed_ledger_ac = null;
            $trans_type = AccountsCoa::TRANS_TYPE_SALES_RECEIPT;
            //$discount_allowed = $request->total_discount;
            $net_total = $request->net_total;
            $total_tax = $request->total_tax;
            $currency = $request->currency;
            if($customer){
                $inputs['customer_id'] = $customer->id;
            }
            $new_sales_receipt = $company->salesReceipts()->create($inputs);
            $new_sales_receipt->trans_number = $this->helper->create_transaction_number($sales_receipt_prefix,$new_sales_receipt->id);
            $new_sales_receipt->save();
            //
            //Items & Taxations
            $tax_id_array = array();
            $tax_value_array = array();
            $items = $request->items;
            for ($j=0; $j < sizeof($items); $j++) {
                //Process Items Here
                $current_item = $items[$j];
                $qty = $items[$j]['qty'];
                $product_item = $this->productItems->findByUuid($items[$j]['id']);
                $price = $this->product_pricing->createPrice($product_item->id,
                $company->id,$items[$j]['price']['unit_cost'],$items[$j]['price']['unit_retail_price'],
                $items[$j]['price']['pack_cost'],$items[$j]['price']['pack_retail_price'],$request->user()->id);
                $item_inputs = [
                    'sales_receipt_id'=>$new_sales_receipt->id,
                    'qty'=>$qty,
                    'discount_rate'=>$items[$j]['discount_rate'],
                    'product_price_id'=>$price->id,
                    'product_item_id'=>$product_item->id,
                ];
                $sales_receipt_item = $new_sales_receipt->items()->create($item_inputs);
                //
                $item_taxes = $current_item['applied_tax_rates'];
                //Log::info($item_taxes);
                for ($i=0; $i < sizeof($item_taxes); $i++) { 
                    //get Tax from DB
                    $taxe = $this->productTaxations->findByUuid($item_taxes[$i]);
                    $tax_inputs = [
                        'sales_rate'=>$taxe->sales_rate,
                        'purchase_rate'=>$taxe->purchase_rate,
                        'collected_on_sales'=>$taxe->collected_on_sales,
                        'collected_on_purchase'=>$taxe->collected_on_purchase,
                        'product_taxation_id'=>$taxe->id,
                        'sales_receipt_item_id'=>$sales_receipt_item->id,
                    ];
                    $item_taxation = CustomerSalesReceiptItemTaxation::create($tax_inputs);
                }

                //Output-Tax on different "VAT type" is totalized(Collected) as below
                if( sizeof($items[$j]['applied_tax_rates']) ){
                    $applied_tax_id = $items[$j]['applied_tax_rates'][0];
                    $line_tax = $items[$j]['line_taxation'];
                    $line_tax_backend = 0;
                    $vat_type = $this->productTaxations->findByUuid($applied_tax_id);
                    if($vat_type->collected_on_sales){
                        $price = $product_item->price_record()->get()->first();
                        if($vat_type->sales_rate){
                            $line_tax_backend = (($vat_type->sales_rate/100) * $price->pack_retail_price) * $qty;
                        }
                    }
                    //Log Discrepancy
                    if($line_tax_backend != $line_tax){
                        Log::info("Discrepancy: Invoice No. ".$new_sales_receipt->trans_number." Front Tax ".$line_tax." Back Tax ".$line_tax_backend);
                    }
                    //
                    if( !in_array($applied_tax_id,$tax_id_array) ){
                        array_push($tax_id_array,$applied_tax_id);
                        array_push($tax_value_array,$line_tax_backend);
                    }else{
                        $key_is = array_search($applied_tax_id, $tax_id_array);
                        $tax_value_array[$key_is] = $tax_value_array[$key_is] + $line_tax_backend;
                    }
                }
            }

            //Accounting begins here
            $sales_ledger_account = $company->chart_of_accounts()->where('default_code',$sales_ac_code)->get()->first();
            /* Company Discount Allowed*/
            $discount_allowed_ledger_ac = $company->chart_of_accounts()->where('default_code',$disc_allowed_code)->get()->first();
            $ledger_support_document = $new_sales_receipt->double_entry_support_document()->create(['trans_type'=>$trans_type]);
            //VAT Journals Entries
            if( sizeof($tax_id_array) ){
                //Collect Taxa
                $debited_ac = $bank_ledger_ac_received->code;
                for ($tz=0; $tz < sizeof($tax_id_array); $tz++) {
                    //GetCompany Tax record record from Register(at Main Branch)
                    $product_taxation = $this->productTaxations->findByUuid($tax_id_array[$tz]);
                    //Get Branch Taxation Record
                    $practice_taxation = $product_taxation->practice_taxation()
                        ->where('practice_id',$company->id)
                        ->get()
                        ->first();
                    $company_tax_ledger_ac = $practice_taxation->ledger_accounts()->get()->first();
                    $credited_ac = $company_tax_ledger_ac->code;
                    $amount = $tax_value_array[$tz];
                    $trans_name = "Output tax ".$product_taxation->name;
                    $transaction_id = $this->helper->getToken(10,'INV');
                    $tax_double_entry = $this->accountDoubleEntries->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);
                    $tax_support = $tax_double_entry->supports()->save($ledger_support_document);
                }
            }
            //Discount Journal Entries

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }

        DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->rollBack();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
        DB::connection(Module::MYSQL_DB_CONN)->rollBack();
        return response()->json($http_resp);

    }
}

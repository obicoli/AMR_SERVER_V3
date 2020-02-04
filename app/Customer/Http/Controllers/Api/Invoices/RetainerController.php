<?php

namespace App\Customer\Http\Controllers\Api\Invoices;

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
use App\Customer\Models\Invoice\CustomerRetainerInvoice;
use App\Finance\Models\Banks\AccountsBank;
use App\Finance\Models\Banks\BankTransaction;
use App\Finance\Repositories\FinanceRepository;

class RetainerController extends Controller
{
    //
    protected $estimates;
    protected $customerRetainerInvoice;
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

    public function __construct(CustomerRetainerInvoice $customerRetainerInvoice)
    {
        $this->customerRetainerInvoice = new CustomerRepository($customerRetainerInvoice);
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
            $invoices = $customer->retainerInvoices()
                ->where('status',$partial_paid_status)
                ->orWhere('status',$unpaid_status)
                ->orderByDesc('created_at')
                ->paginate(100);
        }else{
            $invoices = $company->retainerInvoices()->orderByDesc('created_at')->paginate(10);
        }
        
        $paged_data = $this->helper->paginator($invoices);
        foreach($invoices as $invoice){
            array_push($results,$this->customerSalesOrder->transform_retainer_invoice($invoice));
        }
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function create(Request $request){
        $http_resp = $this->http_response['200'];
        $results = array();
        $company = $this->practices->find($request->user()->company_id); //Get the company

        $inputs = $request->all();
        $http_resp = $this->http_response['200'];
        $rule = [
            'customer_id'=>'required',
            'action_taken'=>'required',
            'overal_discount'=>'required',
            'notes'=>'required',
            'net_total'=>'required',
            'items'=>'required',
            'trans_date'=>'required',
            'due_date'=>'required',
            'terms_condition'=>'required',
            'sales_basis'=>'required',
        ];
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->beginTransaction();
        // DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        // DB::connection(Module::MYSQL_FINANCE_DB_CONN)->beginTransaction();
        // DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        // DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try{

            //$sales_ac_code = AccountsCoa::AC_SALES_CODE;
            //$disc_allowed_code = AccountsCoa::AC_DISCOUNT_ALLOWED_CODE;
            $as_at = $this->helper->format_lunox_date($inputs['trans_date']);
            //$inputs['due_date'] = $this->helper->format_lunox_date($inputs['due_date']);
            $inputs['trans_date'] = $as_at;
            $company = $this->practices->find($request->user()->company_id); //Get the company
            $practiceParent = $this->practices->findParent($company);
            $finance_settings = $company->practice_finance_settings()->get()->first(); //
            //$invoice_prefix = $finance_settings->inv_prefix;
            $retainer_prefix = "RET-";
            $company_user = $this->company_users->find($request->user()->company_id); //Get current user
            $customer = $this->customers->findByUuid($request->customer_id);

            // $invoice_basis_type = $request->sales_basis;
            // $cash_basis_invoice = AccountsCoa::CASH;
            // $unpaid_status = Product::STATUS_UNPAID;
            // $ledger_support_document = null;
            // $discount_allowed_ledger_ac = null;
            if($customer){
                $inputs['customer_id'] = $customer->id;
            }
            $trans_type = AccountsCoa::TRANS_TYPE_RETAINER_INVOICE;
            //$discount_allowed = $request->total_discount;
            $net_total = $request->net_total;
            $total_tax = $request->total_tax;
            $currency = $request->currency;
            $mapped_estimate = $this->estimates->findByUuid($request->estimate_id);
            if($mapped_estimate){
                $inputs['estimate_id'] = $mapped_estimate->id;
            }
            //$mapped_salesorder = $this->customerSalesOrder->findByUuid($request->sales_order_id);
            $new_retainer_invoice = $company->retainerInvoices()->create($inputs);
            $new_retainer_invoice->trans_number = $this->helper->create_transaction_number($retainer_prefix,$new_retainer_invoice->id);
            $new_retainer_invoice->save();

            //Status updates
            $draft_status = Product::STATUS_DRAFT;
            $status = null;
            switch ( $request->action_taken ) {
                case Product::ACTIONS_SAVE_DRAFT:
                    $status = Product::STATUS_DRAFT;
                    break;
                case Product::ACTIONS_SAVE_NEW:
                case Product::ACTIONS_SAVE_CLOSE:
                    $status = Product::STATUS_PENDING_APPROVAL;
                    break;
                case Product::ACTIONS_SAVE_SEND:
                case Product::ACTIONS_SAVE_OPEN:
                    //Schedule this Email to be Send
                    //Schedule mail
                    $status = Product::STATUS_OPEN;
                    $send_to = null;
                    if($customer){ $send_to = $customer->email; }
                    $subj = MailBox::RETAINER_INVOICE;
                    // $mailing_address['subject'] = MailBox::ESTIMATE_SUBJECT;
                    // $mailing_address['msg'] = MailBox::EST_MSG;
                    $mailing_address['subject'] = $subj.' '.$new_retainer_invoice->trans_number;
                    $mailing_address['subject_type'] = $subj;
                    $mailing_address['msg'] = "";
                    $mailing_address['email'] = $send_to;
                    //$this->helper->sendOrders($mailing_address,$shipping_address,$order_data,MailBox::PO_SUBJECT);
                    $mailbox = $practiceParent->product_email_notifications()->create($mailing_address);
                    $mailbox = $company->product_email_notifications()->save($mailbox);
                    $attachment = $mailbox->attatchments()->create(['attachment_type'=>$subj]);
                    $attachment = $new_retainer_invoice->mails_attachments()->save($attachment);
                    break;
                default:
                    $status = Product::STATUS_PENDING;
                    break;
            }

            $status_inputs['status'] = $status;
            $status_inputs['type'] = 'status';
            $status_inputs['notes'] = 'A Retainer invoice created for '.$currency.' '.number_format($net_total,2);
            $invoice_status = $company_user->retainer_invoice_status()->create($status_inputs);
            $invoice_status = $new_retainer_invoice->invoiceStatus()->save($invoice_status);
            $new_retainer_invoice->status = $status_inputs['status'];
            $new_retainer_invoice->save();

            $items = $request->items;
            for ($i=0; $i < sizeof($items); $i++) { 
                $item = $new_retainer_invoice->items()->create($items[$i]);
            }

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->rollBack();
            //DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            //DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
            //DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            //DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }

        DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->commit();
        // DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
        // DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
        // DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
        // DB::connection(Module::MYSQL_DB_CONN)->rollBack();
        return response()->json($http_resp);
    }

    public function show(Request $request,$uuid){
        $http_resp = $this->http_response['200'];
        $payments = array();
        $journals = array();
        $payments = array();
        $audit_trails = array();
        $items = array();
        $invoice = $this->customerRetainerInvoice->findByUuid($uuid);
        // $payment_term = $invoice->payment_terms()->get()->first();
        $est_statuses = $invoice->invoiceStatus()->get();
        $trans_status = array();
        foreach ($est_statuses as $est_status) {
            $temp_status['id'] = $est_status->uuid;
            $temp_status['status'] = $est_status->status;
            $temp_status['notes'] = $est_status->notes;
            $temp_status['date'] = $this->helper->format_mysql_date($est_status->created_at);
            $practice_user = $est_status->responsible()->get()->first();
            $temp_status['signatory'] = $this->company_users->transform_user($practice_user);
            array_push($audit_trails,$temp_status);
        }

        $payment_transactions = $invoice->customerPayments()->orderByDesc('created_at')->get();
        foreach($payment_transactions as $payment_transaction){
            $payitems = array();
            $retainers_in_payment = $payment_transaction->customerRetainerInvoices()->get();
            //Log::info($payitems);
            foreach($retainers_in_payment as $retainers_in_paymen){
                $net_total = $retainers_in_paymen->net_total;
                $dat = $this->customerRetainerInvoice->transform_retainer_invoice($retainers_in_paymen);
                $paid_amount = $retainers_in_paymen->paymentItems()->where('customer_payment_id',$payment_transaction->id)->sum('paid_amount');
                $dat['paid_amount'] = $paid_amount;
                $dat['balance_due'] = $net_total - $paid_amount;
                array_push($payitems,$dat);
            }
            //Log::info($retainers_in_payment);
            $transformed_payment = $this->customerRetainerInvoice->transform_payment($payment_transaction);
            $transformed_payment['items'] = $payitems;
            array_push($payments,$transformed_payment);
            //Log::info($transformed_payment);
        }
        $invoice_data = $this->customerRetainerInvoice->transform_retainer_invoice($invoice);
        // if($payment_term){$invoice_data['payment_term'] = $this->customerRetainerInvoice->transform_term($payment_term);}else{$invoice_data['payment_term']=null;}
        $invoice_data['journals'] = $journals;
        $invoice_data['payments'] = $payments;
        $invoice_data['audit_trails'] = $audit_trails;
        $invoice_data['items'] = $items;
        $http_resp['results'] = $invoice_data;
        return response()->json($http_resp);
    }

}

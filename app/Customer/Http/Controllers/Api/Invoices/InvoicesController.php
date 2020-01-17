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
use App\Finance\Models\Banks\AccountsBank;
use App\Finance\Models\Banks\BankTransaction;
use App\Finance\Repositories\FinanceRepository;

class InvoicesController extends Controller
{
    protected $estimates;
    protected $customerInvoice;
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

    public function __construct(CustomerInvoice $customerInvoice)
    {
        $this->customerInvoice = new CustomerRepository($customerInvoice);
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
            $invoices = $customer->customerInvoices()
                ->where('status',$partial_paid_status)
                ->orWhere('status',$unpaid_status)
                ->orderByDesc('created_at')
                ->paginate(100);
        }else{
            $invoices = $company->customerInvoices()->orderByDesc('created_at')->paginate(10);
        }
        
        $paged_data = $this->helper->paginator($invoices);
        foreach($invoices as $invoice){
            array_push($results,$this->customerSalesOrder->transform_invoices($invoice));
        }
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function show(Request $request,$uuid){
        $http_resp = $this->http_response['200'];
        $payments = array();
        $journals = array();
        $payments = array();
        $audit_trails = array();
        $items = array();
        $invoice = $this->customerInvoice->findByUuid($uuid);
        $payment_term = $invoice->payment_terms()->get()->first();
        $invoice_data = $this->customerInvoice->transform_invoices($invoice);
        if($payment_term){$invoice_data['payment_term'] = $this->customerInvoice->transform_term($payment_term);}else{$invoice_data['payment_term']=null;}
        
        $invoice_data['journals'] = $journals;
        $invoice_data['payments'] = $payments;
        $invoice_data['audit_trails'] = $audit_trails;
        $invoice_data['items'] = $this->customerInvoice->transform_items($invoice,$invoice_data);
        $http_resp['results'] = $invoice_data;
        return response()->json($http_resp);
    }

    public function create(Request $request){
        //Log::info($request);
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

        $discount_allowed = 0;
        if($request->overal_discount){
            $rule = [
                'overal_discount_rate'=>'required',
            ];
            $validation = Validator::make($request->all(),$rule,$this->helper->messages());
            if ( $validation->fails()){
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                return response()->json($http_resp,422);
            }elseif($request->overal_discount_rate>0){
                $discount_allowed = ($request->overal_discount_rate/100) * $request->net_total;
            }else{
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ['Overal discount rate is required!'];
                return response()->json($http_resp,422);
            }
        }else{
            //overal_discount_rate
            $inputs['overal_discount_rate'] = 0;
        }

        /* Bank Ledger AC Received the Paid Amount */
        $bank_ledger_ac_received = null;
        if($request->sales_basis == "Cash"){
            $rule = [
                'cash_paid'=>'required',
                'cash_balance'=>'required',
                'bank_account_id'=>'required',
                'cheque_number'=>'required',
            ];
            $validation = Validator::make($request->payment,$rule,$this->helper->messages());
            if ( $validation->fails()){
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                return response()->json($http_resp,422);
            }else{
                $bank_account = $this->bankAccounts->findByUuid($request->payment['bank_account_id']);
                $bank_ledger_ac_received = $bank_account->ledger_accounts()->get()->first();
            }
        }

        DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try{
            /*
                Accounting and journal entry for credit sales include 2 accounts, "debtor" and "sales."
                In case of a journal entry for cash sales, "cash account" and "sales account" are used.
            */
            //----------
            $sales_ac_code = AccountsCoa::AC_SALES_CODE;
            $disc_allowed_code = AccountsCoa::AC_DISCOUNT_ALLOWED_CODE;
            $as_at = $this->helper->format_lunox_date($inputs['trans_date']);
            $inputs['due_date'] = $this->helper->format_lunox_date($inputs['due_date']);
            $inputs['trans_date'] = $as_at;
            $company = $this->practices->find($request->user()->company_id); //Get the company
            $practiceParent = $this->practices->findParent($company);
            $finance_settings = $company->practice_finance_settings()->get()->first(); //
            $invoice_prefix = $finance_settings->inv_prefix;
            $payment_prefix = "RCP-";
            $company_user = $this->company_users->find($request->user()->company_id); //Get current user
            $customer = $this->customers->findByUuid($request->customer_id);
            $invoice_basis_type = $request->sales_basis;
            $cash_basis_invoice = AccountsCoa::CASH;
            $unpaid_status = Product::STATUS_UNPAID;
            $ledger_support_document = null;
            $discount_allowed_ledger_ac = null;
            $trans_type = AccountsCoa::TRANS_TYPE_TAX_INVOICE;
            //$discount_allowed = $request->total_discount;
            $net_total = $request->net_total;
            $total_tax = $request->total_tax;
            $currency = $request->currency;
            $mapped_estimate = $this->estimates->findByUuid($request->estimate_id);
            $mapped_salesorder = $this->customerSalesOrder->findByUuid($request->sales_order_id);

            //Ledger accounts
            $customer_ledger_ac = null; /*  A/C Receivable */
            //Company Sales account
            if($customer){
                $inputs['customer_id'] = $customer->id;
                $customer_ledger_ac = $customer->ledger_accounts()->get()->first();
            }

            $payment_term = $this->customerTerms->findByUuid($request->payment_term_id);
            if($payment_term){
                $inputs['payment_term_id'] = $payment_term->id;
            }
            //--------
            $new_invoice = $company->customerInvoices()->create($inputs);
            $new_invoice->trans_number = $this->helper->create_transaction_number($invoice_prefix,$new_invoice->id);
            $new_invoice->save();
            
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
                    $subj = MailBox::TAX_INVOICE_SUBJECT;
                    // $mailing_address['subject'] = MailBox::ESTIMATE_SUBJECT;
                    // $mailing_address['msg'] = MailBox::EST_MSG;
                    $mailing_address['subject'] = $subj.' '.$new_invoice->trans_number;
                    $mailing_address['subject_type'] = $subj;
                    $mailing_address['msg'] = "";
                    $mailing_address['email'] = $send_to;
                    //$this->helper->sendOrders($mailing_address,$shipping_address,$order_data,MailBox::PO_SUBJECT);
                    $mailbox = $practiceParent->product_email_notifications()->create($mailing_address);
                    $mailbox = $company->product_email_notifications()->save($mailbox);
                    $attachment = $mailbox->attatchments()->create(['attachment_type'=>$subj]);
                    $attachment = $new_invoice->mails_attachments()->save($attachment);
                    break;
                default:
                    $status = Product::STATUS_PENDING;
                    break;
            }
            
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
                    'customer_invoice_id'=>$new_invoice->id,
                    'qty'=>$qty,
                    'discount_rate'=>$items[$j]['discount_rate'],
                    'product_price_id'=>$price->id,
                    'product_item_id'=>$product_item->id,
                ];
                $salesorder_item = $new_invoice->items()->create($item_inputs);
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
                        'customer_invoice_item_id'=>$salesorder_item->id,
                    ];
                    $item_taxation = DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->table('customer_invoice_item_taxations')->insert($tax_inputs);
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
                        Log::info("Discrepancy: Invoice No. ".$new_invoice->trans_number." Front Tax ".$line_tax." Back Tax ".$line_tax_backend);
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

            //ACCOUNTINGS: Journal Entries
            if($status != $draft_status ){ //Perform Accounting Double Entries only if Status is not a DRAFT
                /*  Company Sales A/C-  */
                $sales_ledger_account = $company->chart_of_accounts()->where('default_code',$sales_ac_code)->get()->first();
                /* Company Discount Allowed*/
                $discount_allowed_ledger_ac = $company->chart_of_accounts()->where('default_code',$disc_allowed_code)->get()->first();
                $ledger_support_document = $new_invoice->double_entry_support_document()->create(['trans_type'=>$trans_type]);
                //VAT Journals
                if( sizeof($tax_id_array) ){
                    if( $invoice_basis_type == $cash_basis_invoice ){//Cash Basis
                        //$credited_ac = $ledger_ac_paid_this_bill->code;
                        $debited_ac = $bank_ledger_ac_received->code;
                    }else{//Credit Basis
                        $debited_ac = $customer_ledger_ac->code;
                    }
                    //Collect Taxa
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
                //Discount Entries
                if($discount_allowed>0){
                    $trans_name = "Discount received";
                    $amount = $discount_allowed;
                    $transaction_id = $this->helper->getToken(10,'DISC');
                    $debited_ac = $discount_allowed_ledger_ac->code;
                    $credited_ac = $customer_ledger_ac->code;
                    $double_entry = $this->accountDoubleEntries->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);
                    $support = $double_entry->supports()->save($ledger_support_document);
                }
                //Actual Sales Entry
                $amount = $net_total - $total_tax - $discount_allowed;
                $transaction_id = $this->helper->getToken(10,'INV');
                $credited_ac = $sales_ledger_account->code;
                $trans_name = "Tax Invoice ".$new_invoice->trans_number;
                if( $invoice_basis_type == $cash_basis_invoice ){//Cash Basis
                    $debited_ac = $bank_ledger_ac_received->code;
                }else{//Credit Basis
                    $debited_ac = $customer_ledger_ac->code;
                }
                $double_entry = $this->accountDoubleEntries->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);
                $support = $double_entry->supports()->save($ledger_support_document);
            }

            if( $invoice_basis_type == $cash_basis_invoice ){
                //Record this payment into Payments table as below
                $notes = "Payment for Invoice ".$new_invoice->trans_number;
                $cash_paid = $request->payment['cash_paid'];
                $pay_reference = $new_invoice->trans_number;
                $pay_inputs['amount'] = $cash_paid;
                $pay_inputs['customer_invoice_id'] = $new_invoice->id;
                $pay_inputs['customer_id'] = $customer->id;
                $pay_inputs['trans_date'] = $as_at;
                $pay_inputs['ledger_account_id'] = $bank_ledger_ac_received->id;
                //$pay_inputs['payment_method'] = $payment_method;
                $pay_inputs['notes'] = $notes;
                $pay_inputs['reference_number'] = $pay_reference;
                $pay_inputs['trans_number'] = $payment_prefix;
                $new_customer_payment = $company->customer_payments()->create($pay_inputs);
                $new_customer_payment->trans_number = $this->helper->create_transaction_number($payment_prefix,$new_customer_payment->id);
                $new_customer_payment->save();
                //Bank Transaction recorded below:
                $received = $net_total - $discount_allowed;
                $account_type_customer = AccountsCoa::AC_TYPE_CUSTOMER;
                $trans_type_customer_payment = AccountsCoa::TRANS_TYPE_CUSTOMER_PAYMENT;
                $bank_reference = $request->payment['cheque_number'];
                //Bank Transaction is Recorded
                /*
                    Any Bank Transaction Recorded to the system, 
                    "reference_number" must be an issued reference number 
                    from the bank institution, this is important when it comes to bank reconciliation
                */
                $transactions['bank_account_id'] = $bank_account->id;
                $transactions['transaction_date'] = $as_at;
                //$transactions['spent'] = $spent;
                $transactions['received'] = $received;
                $transactions['type'] = $account_type_customer;
                $transactions['name'] = $trans_type_customer_payment;
                $transactions['payee'] = $customer->legal_name;
                $transactions['description'] = $notes;
                $transactions['reference'] = $bank_reference;
                $transactions['discount'] = $discount_allowed;
                $transactions['comment'] = $notes;
                $bank_transaction = $new_customer_payment->bank_transactions()->create($transactions);//Create and Link this transaction to Customer Payments
                $bank_transaction = $company->bank_transactions()->save($bank_transaction);//Link transaction to a company
                $bank_account_reconciliation = $this->bankTransactions->getOrCreateBankReconciliation($bank_account,$as_at,null);
                $this->bankTransactions->reconcile_bank_transaction($company_user,$bank_account_reconciliation,$bank_transaction,$bank_account,null,AccountsCoa::RECONCILIATION_NOT_TICKED);
                $status = Product::STATUS_PAID;
            }

            if($status != $draft_status ){
                if($invoice_basis_type != $cash_basis_invoice){
                    $status = $unpaid_status;
                }
            }
            $status_inputs['status'] = $status;
            $status_inputs['type'] = 'status';
            $invoice_status = $company_user->customer_invoice_status()->create($status_inputs);
            $invoice_status = $new_invoice->invoiceStatus()->save($invoice_status);
            $new_invoice->status = $status_inputs['status'];
            $new_invoice->save();

            //Map to Estimate if this invoice is Extracted from the Estimate
            if($mapped_estimate){
                $mapped_estimate->invoices()->save($new_invoice);
                $inputs['estimate_id'] = $mapped_estimate->id;
                $invoiced_status = Product::STATUS_INVOICED;
                $estimate_status_inputs['status'] = $invoiced_status;
                $estimate_status_inputs['type'] = 'status';
                $estimate_status_inputs['notes'] = 'Quotation invoiced for '.$currency.' '.$net_total;
                $estimate_status = $company_user->estimate_status()->create($estimate_status_inputs);
                $estimate_status = $mapped_estimate->estimate_status()->save($estimate_status);
                $mapped_estimate->status = $invoiced_status;
                $mapped_estimate->save();
                $new_invoice->extractable_from = "Quotation";
                $new_invoice->save();
            }

            if($mapped_salesorder){
                $mapped_salesorder->invoices()->save($new_invoice);
                $inputs['sales_order_id'] = $mapped_salesorder->id;
                $invoiced_status = Product::STATUS_INVOICED;
                $salesorder_status_inputs['status'] = $invoiced_status;
                $salesorder_status_inputs['type'] = 'status';
                $salesorder_status_inputs['notes'] = 'Sales Order invoiced for '.$currency.' '.$net_total;
                $sales_order_status = $company_user->salesorder_status()->create($salesorder_status_inputs);
                $sales_order_status = $mapped_salesorder->salesorderStatus()->save($sales_order_status);
                $mapped_salesorder->status = $invoiced_status;
                $mapped_salesorder->save();
                $new_invoice->extractable_from = "Sales Order";
                $new_invoice->save();
            }
            $http_resp['description'] = "Customer invoice successful created!";
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
        //
        DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->commit();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->commit();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        return response()->json($http_resp);
    }
}

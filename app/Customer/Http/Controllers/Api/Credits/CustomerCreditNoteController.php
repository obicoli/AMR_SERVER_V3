<?php

namespace App\Customer\Http\Controllers\Api\Credits;

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
use App\Customer\Models\Credits\CustomerCreditNote;
use App\Customer\Models\Credits\CustomerCreditNoteTaxation;
use App\Customer\Models\Sales\CustomerSalesReceipt;
use App\Customer\Models\Sales\CustomerSalesReceiptItemTaxation;
use App\Finance\Models\Banks\AccountsBank;
use App\Finance\Models\Banks\BankTransaction;
use App\Finance\Repositories\FinanceRepository;

class CustomerCreditNoteController extends Controller
{
    protected $estimates;
    protected $customerSalesReceipt;
    protected $customerCreditNote;
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

    public function __construct(CustomerCreditNote $customerCreditNote)
    {
        $this->customerCreditNote = new CustomerRepository($customerCreditNote);
        $this->estimates = new CustomerRepository( new Estimate() );
        //$this->customerSalesOrder = new CustomerRepository( new CustomerSalesOrder() );
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

    public function show(Request $request,$uuid){
        $http_resp = $this->http_response['200'];
        $credit_note = $this->customerCreditNote->findByUuid($uuid);
        $trans_credit_note = $this->customerCreditNote->transform_credit_note($credit_note);
        //
        $journals = array();
        $support_document = $credit_note->double_entry_support_document()->get()->first();
        if($support_document){
            $journal_entries = $support_document->accounts_vouchers()->get();
            foreach($journal_entries as $journal_entry){
                array_push($journals,$this->accountDoubleEntries->create_journal_report($journal_entry));
            }
        }
        
        //
        $audit_trails = array();

        //
        $trans_credit_note['journals'] = $journals;
        $trans_credit_note['audit_trails'] = $audit_trails;
        $trans_credit_note['items'] = $this->customerCreditNote->transform_items($credit_note,$trans_credit_note);
        $http_resp['results'] = $trans_credit_note;
        return response()->json($http_resp);
    }

    public function index(Request $request){

        $http_resp = $this->http_response['200'];
        //Log::info($request);
        $results = array();
        $company = $this->practices->find($request->user()->company_id); //Get the company
        $credit_notes = $company->customerCreditNotes()->orderByDesc('created_at')->paginate(10);
        $paged_data = $this->helper->paginator($credit_notes);
        foreach($credit_notes as $credit_note){
            array_push($results,$this->customerCreditNote->transform_credit_note($credit_note));
        }
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function create(Request $request){

        //Log::info($request);
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

        // $rule2 = [
        //     'cash_paid'=>'required',
        //     'cash_balance'=>'required',
        //     'bank_account_id'=>'required',
        //     'cheque_number'=>'required',
        // ];
        // $validation = Validator::make($request->payment,$rule2,$this->helper->messages());
        // if ( $validation->fails()){
        //     $http_resp = $this->http_response['422'];
        //     $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
        //     return response()->json($http_resp,422);
        // }

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
                //$discount_allowed = ($request->overal_discount_rate/100) * $request->net_total;
            }else{
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ['Overal discount rate is required!'];
                return response()->json($http_resp,422);
            }
        }else{
            //overal_discount_rate
            $inputs['overal_discount_rate'] = 0;
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
            $credit_note_prefix = "CRN-";
            $company_user = $this->company_users->find($request->user()->company_id); //Get current user
            $customer = $this->customers->findByUuid($request->customer_id);
            $customer_ledger_ac = null;
            //$invoice_basis_type = $request->sales_basis;
            //$cash_basis_invoice = AccountsCoa::CASH;
            //$unpaid_status = Product::STATUS_UNPAID;
            //$active_status = Product::STATUS_ACTIVE;
            // $bank_account = $this->bankAccounts->findByUuid($request->payment['bank_account_id']);
            // $bank_ledger_ac_received = $bank_account->ledger_accounts()->get()->first();
            $ledger_support_document = null;
            $discount_allowed_ledger_ac = null;
            $trans_type = AccountsCoa::TRANS_TYPE_SALES_RECEIPT;
            $discount_allowed = $request->total_discount;
            $net_total = $request->net_total;
            $total_tax = $request->total_tax;
            $currency = $request->currency;
            $notes = $request->notes;
            if($customer){
                $inputs['customer_id'] = $customer->id;
                $customer_ledger_ac = $customer->ledger_accounts()->get()->first();
            }
            $new_credit_note = $company->customerCreditNotes()->create($inputs);
            $new_credit_note->trans_number = $this->helper->create_transaction_number($credit_note_prefix,$new_credit_note->id);
            $new_credit_note->save();

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
                    $mailing_address['subject'] = $subj.' '.$new_credit_note->trans_number;
                    $mailing_address['subject_type'] = $subj;
                    $mailing_address['msg'] = "";
                    $mailing_address['email'] = $send_to;
                    //$this->helper->sendOrders($mailing_address,$shipping_address,$order_data,MailBox::PO_SUBJECT);
                    $mailbox = $practiceParent->product_email_notifications()->create($mailing_address);
                    $mailbox = $company->product_email_notifications()->save($mailbox);
                    $attachment = $mailbox->attatchments()->create(['attachment_type'=>$subj]);
                    $attachment = $new_credit_note->mails_attachments()->save($attachment);
                    break;
                default:
                    $status = Product::STATUS_PENDING;
                    break;
            }
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
                    'credit_note_id'=>$new_credit_note->id,
                    'qty'=>$qty,
                    'discount_rate'=>$items[$j]['discount_rate'],
                    'product_price_id'=>$price->id,
                    'product_item_id'=>$product_item->id,
                ];
                $credit_note_item = $new_credit_note->items()->create($item_inputs);
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
                        'credit_note_item_id'=>$credit_note_item->id,
                    ];
                    $item_taxation = CustomerCreditNoteTaxation::create($tax_inputs);
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
                        Log::info("Discrepancy: Invoice No. ".$new_credit_note->trans_number." Front Tax ".$line_tax." Back Tax ".$line_tax_backend);
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

            if( ($status == Product::STATUS_OPEN) ){

                //Accounting begins here
                $sales_ledger_account = $company->chart_of_accounts()->where('default_code',$sales_ac_code)->get()->first();
                /* Company Discount Allowed*/
                $discount_allowed_ledger_ac = $company->chart_of_accounts()->where('default_code',$disc_allowed_code)->get()->first();
                $ledger_support_document = $new_credit_note->double_entry_support_document()->create(['trans_type'=>$trans_type]);
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
                if($customer_ledger_ac && ($discount_allowed>0) ){
                    $trans_name = "Discount allowed";
                    $amount = $discount_allowed;
                    $transaction_id = $this->helper->getToken(10,'DSCA');
                    $debited_ac = $discount_allowed_ledger_ac->code;
                    $credited_ac = $customer_ledger_ac->code;
                    $double_entry = $this->accountDoubleEntries->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);
                    $support = $double_entry->supports()->save($ledger_support_document);
                }

                //Cash Sale Journal Entries
                $amount = $net_total - $total_tax - $discount_allowed;
                $debited_ac = $bank_ledger_ac_received->code;
                $credited_ac = $sales_ledger_account->code;
                $trans_name = $notes;
                $transaction_id = $this->helper->getToken(10,'SRT');
                $double_entry = $this->accountDoubleEntries->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);
                $tax_support = $double_entry->supports()->save($ledger_support_document);
            }

            

            $status_inputs['type'] = 'status';
            $status_inputs['status'] = $status;
            $status_inputs['notes'] = 'Sales receipt created for '.$currency.' '.number_format($net_total,2);
            $credit_status = $company_user->credit_note_status()->create($status_inputs);
            $invoice_status = $new_credit_note->noteStatus()->save($credit_status);
            $new_credit_note->status = $status_inputs['status'];
            $new_credit_note->save();
            $http_resp['description'] = "Credit Note successfull created!";

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

        DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->commit();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->commit();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        return response()->json($http_resp);
    }
}

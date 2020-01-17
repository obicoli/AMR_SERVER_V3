<?php

namespace App\Customer\Http\Controllers\Api\Salesorder;

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

class SalesorderController extends Controller
{
    protected $estimates;
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
    protected $customerInvoices;

    public function __construct(CustomerSalesOrder $customerSalesOrder)
    {
        $this->customerSalesOrder = new CustomerRepository($customerSalesOrder);
        $this->estimates = new CustomerRepository( new Estimate() );
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice() );
        $this->customers = new CustomerRepository(new Customer());
        $this->company_users = new PracticeRepository(new PracticeUser());
        $this->productItems = new ProductReposity(new ProductItem());
        $this->product_pricing = new ProductReposity(new ProductPriceRecord());
        $this->productTaxations = new ProductReposity( new ProductTaxation() );
        $this->customerTerms = new CustomerRepository( new CustomerTerms() );
        $this->customerInvoices = new CustomerRepository( new CustomerInvoice() );
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $results = array();
        $company = $this->practices->find($request->user()->company_id); //Get the company
        $salesorders = $company->customerSalesorder()->orderByDesc('created_at')->paginate(10);
        $paged_data = $this->helper->paginator($salesorders);
        foreach($salesorders as $salesorder){
            array_push($results,$this->customerSalesOrder->transform_sales_order($salesorder));
        }
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function show(Request $request,$uuid){

        $http_resp = $this->http_response['200'];
        $salesorder = $this->customerSalesOrder->findByUuid($uuid);
        $invoices = array();
        $quotations = array();
        $audit_trails = array();
        //
        $invoices_list = $salesorder->invoices()->orderByDesc('created_at')->get();
        foreach($invoices_list as $invoices_lis){
            array_push($invoices,$this->customerInvoices->transform_invoices($invoices_lis));
        }
        //
        $estimates = $salesorder->estimates()->orderByDesc('created_at')->get();
        foreach($estimates as $estimate){
            array_push($quotations,$this->estimates->transform_estimate($estimate));
        }
        //
        $sales_order_trails = $salesorder->salesorderStatus()->get();
        foreach ($sales_order_trails as $sales_order_trail) {
            $temp_sta['id'] = $sales_order_trail->uuid;
            $temp_sta['status'] = $sales_order_trail->status;
            $temp_sta['type'] = $sales_order_trail->type;
            $temp_sta['notes'] = $sales_order_trail->notes;
            $temp_sta['date'] = date('Y-m-d H:i:s',\strtotime($sales_order_trail->created_at));
            $practice_user = $sales_order_trail->responsible()->get()->first();
            $temp_sta['signatory'] = $this->company_users->transform_user($practice_user);
            array_push($audit_trails,$temp_sta);
        }
        //
        $salesord = $this->customerSalesOrder->transform_sales_order($salesorder);
        $salesord['invoices'] = $invoices;
        $salesord['audit_trails'] = $audit_trails;
        $salesord['quotations'] = $quotations;
        $salesord['items'] = $this->customerSalesOrder->transform_items($salesorder,$salesord);
        $http_resp['results'] = $salesord;
        return response()->json($http_resp);
    }

    public function create(Request $request){

        Log::info($request);

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
        ];
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        if($request->overal_discount){
            $rule = [
                'overal_discount_rate'=>'required',
            ];
            $validation = Validator::make($request->all(),$rule,$this->helper->messages());
            if ($validation->fails()){
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                return response()->json($http_resp,422);
            }
        }else{
            //overal_discount_rate
            $inputs['overal_discount_rate'] = 0;
        }

        DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        try{

            
            $inputs['due_date'] = $this->helper->format_lunox_date($inputs['due_date']);
            $inputs['trans_date'] = $this->helper->format_lunox_date($inputs['trans_date']);
            $company = $this->practices->find($request->user()->company_id); //Get the company
            $practiceParent = $this->practices->findParent($company);
            $finance_settings = $company->practice_finance_settings()->get()->first(); //
            $sales_order_prefix = $finance_settings->so_prefix;
            $company_user = $this->company_users->find($request->user()->company_id); //Get current user
            $customer = $this->customers->findByUuid($request->customer_id);
            $currency = $request->currency;
            $net_total = $request->net_total;
            if($customer){
                $inputs['customer_id'] = $customer->id;
            }
            $estimate = $this->estimates->findByUuid($request->estimate_id);
            if($estimate){
                $inputs['estimate_id'] = $estimate->id;
                $accepted_status = Product::STATUS_ACCEPTED;
                $invoiced_status = Product::STATUS_INVOICED;
                $closed_status = Product::STATUS_CLOSED;
                if( $estimate->status==$invoiced_status || $estimate->status==$closed_status ){
                    //this is an action but not status
                    $estimate_status_inputs['status'] = $accepted_status;
                    $estimate_status_inputs['type'] = 'action';
                }elseif($estimate->status == $accepted_status){
                    $estimate_status_inputs['status'] = $accepted_status;
                    $estimate_status_inputs['type'] = 'action';
                }else{
                    $estimate_status_inputs['status'] = $accepted_status;
                    $estimate_status_inputs['type'] = 'status';
                    $estimate->status = $accepted_status;
                    $estimate->save();
                }
                $estimate_status_inputs['notes'] = 'Sales Order created for '.$currency.' '.number_format($net_total,2);
                $estimate_status = $company_user->estimate_status()->create($estimate_status_inputs);
                $estimate_status = $estimate->estimate_status()->save($estimate_status);
            }
            $payment_term = $this->customerTerms->findByUuid($request->payment_term_id);
            if($payment_term){
                $inputs['payment_term_id'] = $payment_term->id;
            }
            $new_sales_order = $company->customerSalesorder()->create($inputs);
            $new_sales_order->trans_number = $this->helper->create_transaction_number($sales_order_prefix,$new_sales_order->id);
            $new_sales_order->save();
            //
            $status = Product::STATUS_DRAFT;
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
                    $subj = MailBox::SALES_ORDER_SUBJECT;
                    // $mailing_address['subject'] = MailBox::ESTIMATE_SUBJECT;
                    // $mailing_address['msg'] = MailBox::EST_MSG;
                    $mailing_address['subject'] = $subj.' '.$new_sales_order->trans_number;
                    $mailing_address['subject_type'] = $subj;
                    $mailing_address['msg'] = "";
                    $mailing_address['email'] = $send_to;
                    //$this->helper->sendOrders($mailing_address,$shipping_address,$order_data,MailBox::PO_SUBJECT);
                    $mailbox = $practiceParent->product_email_notifications()->create($mailing_address);
                    $mailbox = $company->product_email_notifications()->save($mailbox);
                    $attachment = $mailbox->attatchments()->create(['attachment_type'=>$subj]);
                    $attachment = $new_sales_order->mails_attachments()->save($attachment);
                    break;
                default:
                    $status = Product::STATUS_PENDING;
                    break;
            }
            $status_inputs['status'] = $status;
            $status_inputs['type'] = 'status';
            $salesorder_status = $company_user->salesorder_status()->create($status_inputs);
            $salesorder_status = $new_sales_order->salesorderStatus()->save($salesorder_status);
            $new_sales_order->status = $status_inputs['status'];
            $new_sales_order->save();
            //--------------
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
                    'sales_order_id'=>$new_sales_order->id,
                    'qty'=>$qty,
                    'discount_rate'=>$items[$j]['discount_rate'],
                    'product_price_id'=>$price->id,
                    'product_item_id'=>$product_item->id,
                ];
                $salesorder_item = $new_sales_order->items()->create($item_inputs);
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
                        'sales_order_item_id'=>$salesorder_item->id,
                    ];
                    $item_taxation = DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->table('salesorder_item_taxations')->insert($tax_inputs);
                }
            }

            $http_resp['description'] = "Sales Order successful created!";

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->commit();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        return response()->json($http_resp);
    }
}

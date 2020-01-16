<?php

namespace App\Customer\Http\Controllers\Api\Estimate;

use App\Customer\Models\Customer;
use App\Customer\Models\CustomerTerms;
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

class EstimateController extends Controller
{

    protected $estimates;
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $customers;
    protected $customerTerms;
    protected $company_users;
    protected $productItems;
    protected $product_pricing;
    protected $productTaxations;

    public function __construct(Estimate $estimates)
    {
        $this->estimates = new CustomerRepository($estimates);
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice() );
        $this->customers = new CustomerRepository(new Customer());
        $this->company_users = new PracticeRepository(new PracticeUser());
        $this->productItems = new ProductReposity(new ProductItem());
        $this->product_pricing = new ProductReposity(new ProductPriceRecord());
        $this->productTaxations = new ProductReposity( new ProductTaxation() );
        $this->customerTerms = new CustomerRepository( new CustomerTerms() );
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $results = array();
        $company = $this->practices->find($request->user()->company_id); //Get the company
        
        if($request->has('customer_id')){
            $customer = $this->customers->findByUuid($request->customer_id);
            $estimatesy = $customer->estimates()
                ->orderByDesc('created_at')
                ->paginate(1000);
        }else{
            $estimatesy = $company->estimates()->orderByDesc('created_at')->paginate(10);
        }
        foreach($estimatesy as $estimate){
            array_push($results,$this->estimates->transform_estimate($estimate) );
        }
        $paged_data = $this->helper->paginator($estimatesy);
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        //$practiceParent = $this->practices->findParent($company);
        return response()->json($http_resp);
    }

    public function create(Request $request){

        //Log::info($request);
        $inputs = $request->all();
        $http_resp = $this->http_response['200'];
        $rule = [
            'customer_id'=>'required',
            'action_taken'=>'required',
            'retainer_invoice'=>'required',
            //'retainer_percentage'=>'required',
            'notes'=>'required',
            //'discount_offered'=>'required',
            'net_total'=>'required',
            //'total_grand'=>'required',
            //'shipping_charges'=>'required',
            'items'=>'required',
            'trans_date'=>'required',
            'due_date'=>'required',
            //'adjustment_charges'=>'required',
            'terms_condition'=>'required',
            //'reference_number'=>'required',
        ];

        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        if($request->retainer_invoice){
            $rule = [
                'retainer_percentage'=>'required',
            ];
            $validation = Validator::make($request->all(),$rule,$this->helper->messages());
            if ($validation->fails()){
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                return response()->json($http_resp,422);
            }
        }

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

        DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        try{

            
            $inputs['due_date'] = $this->helper->format_lunox_date($inputs['due_date']);
            $inputs['trans_date'] = $this->helper->format_lunox_date($inputs['trans_date']);
            $company = $this->practices->find($request->user()->company_id); //Get the company
            $practiceParent = $this->practices->findParent($company);
            $finance_settings = $company->practice_finance_settings()->get()->first(); //
            $est_prefix = $finance_settings->est_prefix;
            $company_user = $this->company_users->find($request->user()->company_id); //Get current user
            $customer = $this->customers->findByUuid($request->customer_id);
            if($customer){
                $inputs['customer_id'] = $customer->id;
            }
            $payment_term = $this->customerTerms->findByUuid($request->payment_term_id);
            if($payment_term){
                $inputs['payment_term_id'] = $payment_term->id;
            }
            
            $new_estimate = $company->estimates()->create($inputs); //Create new Estimate
            $new_estimate->trans_number = $this->helper->create_transaction_number($est_prefix,$new_estimate->id);
            $new_estimate->save();
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
                    $send_to = $customer->email;
                    $subj = MailBox::ESTIMATE_SUBJECT;
                    // $mailing_address['subject'] = MailBox::ESTIMATE_SUBJECT;
                    // $mailing_address['msg'] = MailBox::EST_MSG;
                    $mailing_address['subject'] = $subj.' '.$new_estimate->trans_number;
                    $mailing_address['subject_type'] = $subj;
                    $mailing_address['msg'] = "";
                    $mailing_address['email'] = $send_to;
                    //$this->helper->sendOrders($mailing_address,$shipping_address,$order_data,MailBox::PO_SUBJECT);
                    $mailbox = $practiceParent->product_email_notifications()->create($mailing_address);
                    $mailbox = $company->product_email_notifications()->save($mailbox);
                    $attachment = $mailbox->attatchments()->create(['attachment_type'=>MailBox::ESTIMATE_SUBJECT]);
                    $attachment = $new_estimate->mails_attachments()->save($attachment);
                    break;
                default:
                    $status = Product::STATUS_PENDING;
                    break;
            }

            

            //Process and save Estimate Items
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
                    'estimate_id'=>$new_estimate->id,
                    'qty'=>$qty,
                    'discount_rate'=>$items[$j]['discount_rate'],
                    'product_price_id'=>$price->id,
                    'product_item_id'=>$product_item->id,
                ];
                $estimate_item = $new_estimate->items()->create($item_inputs);
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
                        'estimate_item_id'=>$estimate_item->id,
                    ];
                    $item_taxation = DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->table('estimate_item_taxations')->insert($tax_inputs);
                }
            }

            $status_inputs['status'] = $status;
            $status_inputs['type'] = 'status';
            $estimate_status = $company_user->estimate_status()->create($status_inputs);
            $estimate_status = $new_estimate->estimate_status()->save($estimate_status);
            $new_estimate->status = $status_inputs['status'];
            $new_estimate->save();

            // $inputs = $request->except(['customer_id']);
            // 
            // $practiceParent = $this->practices->findParent($company);
            // $customer = $this->customers->findByUuid($request->customer_id); //Get the customer
            // $company_user = $this->company_users->find($request->user()->company_id); //Get current user
            // $new_estimate = $this->estimates->create($inputs); //Create new Estimate
            // $new_estimate->trans_number = $this->helper->create_transaction_number('EST',$new_estimate->id);
            // $new_estimate = $company->estimates()->save($new_estimate); //Attach this estimate to a company
            // $new_estimate = $customer->estimates()->save($new_estimate); //Attach this estimate to a customer
            // //Determine the Initial status of the estimate depending on the action taken by the user
            // //$new_estimate->trans_number = $this->helper->create_transaction_number('EST',$new_estimate->id);
            // $new_estimate->save();
            // $status = [ 'status'=>Product::STATUS_DRAFT ];
            // switch ( $request->action_taken ) {
            //     case Product::ACTIONS_SAVE_DRAFT:
            //         $status = [ 'status'=>Product::STATUS_DRAFT ];
            //         break;
            //     case Product::ACTIONS_SAVE_SEND:
            //         //Schedule this Email to be Send
            //         //Schedule mail
            //         $mailing_address['subject'] = MailBox::ESTIMATE_SUBJECT;
            //         $mailing_address['msg'] = MailBox::EST_MSG;
            //         //$this->helper->sendOrders($mailing_address,$shipping_address,$order_data,MailBox::PO_SUBJECT);
            //         $mailbox = $practiceParent->product_email_notifications()->create($mailing_address);
            //         $mailbox = $company->product_email_notifications()->save($mailbox);
            //         $attachment = $mailbox->attatchments()->create(['attachment_type'=>MailBox::ESTIMATE_SUBJECT]);
            //         $attachment = $new_estimate->mails_attachments()->save($attachment);
            //         $status = [ 'status'=>Product::STATUS_SENT ];
            //         break;
            //     default:
            //         $status = [ 'status'=>Product::STATUS_PENDING ];
            //         break;
            // }
            // //Create the status  and attach it the user responsible
            // //Then attach it to estimate
            //     $est_status = $company_user->estimate_status()->create($status);
            //     $est_status = $new_estimate->estimate_status()->save($est_status);

            // //Process and save Estimate Items
            // $items = $request->items;
            // //$items_array = array();
            // for ($j=0; $j < sizeof($items); $j++) {
                
            //     $current_item = $items[$j];
            //     $product_item = $this->productItems->findByUuid($items[$j]['id']);
            //     $price = $this->product_pricing->createPrice($product_item->id,
            //     $company->id,$items[$j]['price']['unit_cost'],$items[$j]['price']['unit_retail_price'],
            //     $items[$j]['price']['pack_cost'],$items[$j]['price']['pack_retail_price'],$request->user()->id);
            //     $item_inputs = [
            //         'estimate_id'=>$new_estimate->id,
            //         'qty'=>$items[$j]['qty'],
            //         'discount_allowed'=>$items[$j]['discount_allowed'],
            //         'product_price_id'=>$price->id,
            //         'product_item_id'=>$product_item->id,
            //     ];
            //     //array_push($items_array,$item_inputs);
            //     //Create Estimate Items and Attach them to Estimate
            //     $estimate_item = $new_estimate->items()->create($item_inputs);
            //     //check if this item is applied to taxation and save taxation
            //     $item_taxes = $current_item['taxes'];
            //     for ($i=0; $i < sizeof($item_taxes); $i++) { 
            //         //get Tax from DB
            //         $taxe = $this->productTaxations->findByUuid($item_taxes[$i]['id']);
            //         $tax_inputs = [
            //             'sales_rate'=>$taxe->sales_rate,
            //             'purchase_rate'=>$taxe->purchase_rate,
            //             'collected_on_sales'=>$taxe->collected_on_sales,
            //             'collected_on_purchase'=>$taxe->collected_on_purchase,
            //             'product_taxation_id'=>$taxe->id,
            //             'estimate_item_id'=>$estimate_item->id,
            //         ];
            //         $item_taxation = DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->table('estimate_item_taxations')->insert($tax_inputs);
            //     }
            // }

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        //
        DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->commit();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        return response()->json($http_resp);
    }
    public function update(Request $request,$uuid){}
    public function show($uuid){

        $http_resp = $this->http_response['200'];
        $estimate = $this->estimates->findByUuid($uuid);
        //audit_trails
        $audit_trails = array();
        $invoices = array();
        $salesorders = array();
        $estimate_data = $this->estimates->transform_estimate($estimate);
        $items = $this->estimates->transform_items($estimate,$estimate_data);
        $estimate_data['audit_trails'] = $audit_trails;
        $estimate_data['items'] = $items;
        $estimate_data['invoices'] = $invoices;
        $estimate_data['salesorders'] = $salesorders;
        $http_resp['results'] = $estimate_data;
        return response()->json($http_resp);

    }
    public function delete($uuid){}
}

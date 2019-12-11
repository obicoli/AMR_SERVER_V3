<?php

namespace App\Supplier\Http\Controllers\Api\Purchase;

use App\Customer\Models\Customer;
use App\Customer\Repositories\CustomerRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\helpers\HelperFunctions;
use App\Models\Module\Module;
use App\Models\NotificationCenter\MailBox;
use App\Repositories\Practice\PracticeRepository;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeUser;
use App\Models\Product\Product;
use App\Models\Product\ProductItem;
use App\Models\Product\Sales\ProductPriceRecord;
use App\Repositories\Product\ProductReposity;
use App\Supplier\Models\PurchaseOrder;
use App\Supplier\Models\Supplier;
use App\Supplier\Repositories\SupplierRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Product\ProductTaxation;

class PurchaseOrderController extends Controller
{

    protected $http_response;
    protected $practices;
    protected $helper;
    protected $purchaseOrders;
    protected $productItems;
    protected $suppliers;
    protected $customers;
    protected $company_users;
    protected $product_pricing;
    protected $productTaxations;

    public function __construct( PurchaseOrder $purchaseOrder )
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice() );
        $this->purchaseOrders = new SupplierRepository( $purchaseOrder );
        $this->productItems = new ProductReposity( new ProductItem() );
        $this->suppliers = new SupplierRepository( new Supplier() );
        $this->customers = new CustomerRepository( new Customer() );
        $this->company_users = new PracticeRepository(new PracticeUser());
        $this->product_pricing = new ProductReposity(new ProductPriceRecord());
        $this->productTaxations = new ProductReposity( new ProductTaxation() );
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $company = $this->practices->find($request->user()->company_id);
        //
        if($request->has('filter_by')){
            $po_lists = $company->purchase_orders()
                ->where('status',$request->filter_by)
                ->orderByDesc('created_at')
                ->paginate(10);
        }else{
             $po_lists = $company->purchase_orders()->orderByDesc('created_at')->paginate(10);
        }
        $results = array();
        foreach($po_lists as $po_list){
            array_push($results,$this->suppliers->transform_purchase_order($po_list) );
        }
        $paged_data = $this->helper->paginator($po_lists);
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function update(Request $request,$uuid){

        $http_resp = $this->http_response['200'];
        $action = null;
        // Log::info($request);
        // return response()->json($http_resp);
        if($request->has('action')){
            $action = $request->action;
        }else{
            $rule = [
                'ship_to'=>'required',
                'supplier_id'=>'required',
                'taxation_option'=>'required',
                'po_date'=>'required',
                'po_due_date'=>'required',
                'terms'=>'required',
                'notes'=>'required',
                'items'=>'required',
            ];
            $validation = Validator::make($request->all(),$rule,$this->helper->messages());
            if ($validation->fails()){
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                return response()->json($http_resp,422);
            }

            $shippable = null;
            if( $request->ship_to == Product::SHIP_TO_CUSTOMER ){
                $rule = [
                    'customer_id'=>'required',
                ];
                $validation = Validator::make($request->all(),$rule,$this->helper->messages());
                if ($validation->fails()){
                    $http_resp = $this->http_response['422'];
                    $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                    return response()->json($http_resp,422);
                }else{
                    $shippable = $this->customers->findByUuid($request->customer_id);
                }
            }
    
            if( $request->ship_to == Product::SHIP_TO_ORGANIZATION ){
                $rule = [
                    'facility_id'=>'required',
                ];
                $validation = Validator::make($request->all(),$rule,$this->helper->messages());
                if ($validation->fails()){
                    $http_resp = $this->http_response['422'];
                    $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                    return response()->json($http_resp,422);
                }else{
                    $shippable = $this->practices->findByUuid($request->facility_id);
                }
            }
        }

        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try{

            $user = $request->user();
            $company = $this->practices->find($request->user()->company_id);
            $practiceParent = $this->practices->findParent($company);
            $company_user = $this->company_users->findByUserAndCompany($user,$company);
            $purchase_order = $this->purchaseOrders->findByUuid($uuid);
            //
            if($action){ //Here an action can be "Send Mail","Attach File","Change Status","Convert to Bill"

                switch ($action) {
                    
                    case Product::ACTIONS_SEND_MAIL:
                        $subj = MailBox::PO_SUBJECT;
                        $send_to = $request->send_to;
                        $status['status'] = Product::STATUS_OPEN;
                        $status['notes'] = $subj." emailed to ".$send_to;
                        //Schedule this Email to be Send
                        $mailing_address['subject'] = $request->subject;
                        $mailing_address['subject_type'] = $subj;
                        $mailing_address['msg'] = $request->content;
                        $mailing_address['email'] = $send_to;
                        //$mailing_address['cc'] = $request->cc;
                        $mailbox = $practiceParent->product_email_notifications()->create($mailing_address);
                        $mailbox = $company->product_email_notifications()->save($mailbox);
                        $attachment = $mailbox->attatchments()->create(['attachment_type'=>MailBox::PO_SUBJECT]);
                        $attachment = $purchase_order->mails_attachments()->save($attachment);
                        $purchase_order->status = $status['status'];
                        $purchase_order->save();
                        $po_status = $company_user->po_status()->create($status);
                        $po_status = $purchase_order->po_status()->save($po_status);
                        $http_resp['description'] = "Email successful sent!";
                        break;
                    case Product::ACTIONS_PRINT:
                        $subj = MailBox::PO_SUBJECT;
                        $status['status'] = Product::STATUS_PRINTED;
                        $status['notes'] = $subj." printed";
                        $status['type'] = "action";
                        $po_status = $company_user->po_status()->create($status);
                        $po_status = $purchase_order->po_status()->save($po_status);
                        break;
                    case Product::ACTIONS_COMMENT:
                        $status['status'] = Product::ACTIONS_COMMENT;
                        $status['notes'] = $request->comment;
                        $status['type'] = "action";
                        $po_status = $company_user->po_status()->create($status);
                        $po_status = $purchase_order->po_status()->save($po_status);
                        $http_resp['description'] = "Comment successful added!";
                        break;
                    default:
                        # code...
                        break;
                }

            }else{ //Here user want to edit The Purchase Order
                $supplier = $this->suppliers->findByUuid($request->supplier_id);
                $purchase_order->supplier_id = $supplier->id;
                //Attach to shipping Address
                $purchase_order = $shippable->purchase_order_shipping()->save($purchase_order);
                $po_items = $purchase_order->items()->get();
                foreach($po_items as $po_item){
                    $po_item->forceDelete();
                }
                //Items
                $items = $request->items;
                for ($j=0; $j < sizeof($items); $j++) {
                    $current_item = $items[$j];
                    $product_item = $this->productItems->findByUuid($items[$j]['id']);
                    $price = $this->product_pricing->createPrice($product_item->id,
                    $company->id,$items[$j]['price']['unit_cost'],$items[$j]['price']['unit_retail_price'],
                    $items[$j]['price']['pack_cost'],$items[$j]['price']['pack_retail_price'],$request->user()->id);
                    $item_inputs = [
                        'purchase_order_id'=>$purchase_order->id,
                        'qty'=>$items[$j]['qty'],
                        'product_price_id'=>$price->id,
                        'product_item_id'=>$product_item->id,
                    ];
                    $po_item = $purchase_order->items()->create($item_inputs);
                    $item_taxes = $current_item['taxes'];
                    for ($i=0; $i < sizeof($item_taxes); $i++) { 
                        //get Tax from DB
                        $taxe = $this->productTaxations->findByUuid($item_taxes[$i]['id']);
                        $tax_inputs = [
                            'sales_rate'=>$taxe->sales_rate,
                            'purchase_rate'=>$taxe->purchase_rate,
                            'collected_on_sales'=>$taxe->collected_on_sales,
                            'collected_on_purchase'=>$taxe->collected_on_purchase,
                            'product_taxation_id'=>$taxe->id,
                            'po_item_id'=>$po_item->id,
                        ];
                        $item_taxation = DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->table('po_item_taxations')->insert($tax_inputs);
                    }
                }

            }
            


        }catch( \Exception $e ){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->commit();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function create( Request $request ){
        $http_resp = $this->http_response['200'];
        $rule = [
            'ship_to'=>'required',
            //'facility_id'=>'required',
            //'customer_id'=>'required',
            'supplier_id'=>'required',
            //'shipment_preference'=>'required',
            'taxation_option'=>'required',
            'po_date'=>'required',
            'po_due_date'=>'required',
            'terms'=>'required',
            'notes'=>'required',
            'items'=>'required',
        ];
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        $shippable = null;

        if( $request->ship_to == Product::SHIP_TO_CUSTOMER ){
            $rule = [
                'customer_id'=>'required',
            ];
            $validation = Validator::make($request->all(),$rule,$this->helper->messages());
            if ($validation->fails()){
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                return response()->json($http_resp,422);
            }else{
                $shippable = $this->customers->findByUuid($request->customer_id);
            }
        }

        if( $request->ship_to == Product::SHIP_TO_ORGANIZATION ){
            $rule = [
                'facility_id'=>'required',
            ];
            $validation = Validator::make($request->all(),$rule,$this->helper->messages());
            if ($validation->fails()){
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                return response()->json($http_resp,422);
            }else{
                $shippable = $this->practices->findByUuid($request->facility_id);
            }
        }

        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        try{

            $company = $this->practices->find($request->user()->company_id);
            $practiceParent = $this->practices->findParent($company);
            $supplier = $this->suppliers->findByUuid($request->supplier_id);
            $company_user = $this->company_users->find($request->user()->company_id); //Get current user
            //Create new PO
            $inputs = $request->all();
            $inputs['supplier_id'] = $supplier->id;
            $inputs['po_date'] = $this->helper->format_lunox_date($request->po_date);
            $inputs['po_due_date'] = $this->helper->format_lunox_date($request->po_due_date);
            $new_po = $this->purchaseOrders->create($inputs); //Create new Estimate
            $new_po->trans_number = $this->helper->create_transaction_number('PO',$new_po->id);
            //Attact this PO to a company creating it
            $new_po = $company->purchase_orders()->save($new_po);
            //Attach to shipping Address
            $new_po = $shippable->purchase_order_shipping()->save($new_po);
            //Switch initial state
            $status['status'] = Product::STATUS_DRAFT;
            $subj = MailBox::PO_SUBJECT;
            $status['notes'] = $subj." created for ".$request->currency." ".number_format($request->total_bill,2);

            //Create the status  and attach it the user responsible
            //Then attach it to estimate
            //$status['notes'] = $subj." emailed to ".$send_to;
            $new_po->status = $status['status'];
            $new_po->save();
            $po_status = $company_user->po_status()->create($status);
            $po_status = $new_po->po_status()->save($po_status);

            //Items
            $items = $request->items;
            for ($j=0; $j < sizeof($items); $j++) {
                $current_item = $items[$j];
                $product_item = $this->productItems->findByUuid($items[$j]['id']);
                $price = $this->product_pricing->createPrice($product_item->id,
                $company->id,$items[$j]['price']['unit_cost'],$items[$j]['price']['unit_retail_price'],
                $items[$j]['price']['pack_cost'],$items[$j]['price']['pack_retail_price'],$request->user()->id);
                $item_inputs = [
                    'purchase_order_id'=>$new_po->id,
                    'qty'=>$items[$j]['qty'],
                    'product_price_id'=>$price->id,
                    'product_item_id'=>$product_item->id,
                ];
                //Log::info($current_item['applied_tax_rates']);
                $po_item = $new_po->items()->create($item_inputs);
                $item_taxes = $current_item['applied_tax_rates'];
                //$item_taxes = $current_item['taxes'];
                for ($i=0; $i < sizeof($item_taxes); $i++) { 
                    //get Tax from DB
                    $taxe = $this->productTaxations->findByUuid($item_taxes[$i]);
                    $tax_inputs = [
                        'sales_rate'=>$taxe->sales_rate,
                        'purchase_rate'=>$taxe->purchase_rate,
                        'collected_on_sales'=>$taxe->collected_on_sales,
                        'collected_on_purchase'=>$taxe->collected_on_purchase,
                        'product_taxation_id'=>$taxe->id,
                        'po_item_id'=>$po_item->id,
                    ];
                    $item_taxation = DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->table('po_item_taxations')->insert($tax_inputs);
                }
            }
            $http_resp['results'] = $this->purchaseOrders->transform_purchase_order($new_po);
        }catch( \Exception $e ){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }

        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->commit();
        return response()->json($http_resp);
        
    }

    public function show($uuid){
        $http_resp = $this->http_response['200'];
        $po = $this->purchaseOrders->findByUuid($uuid);
        $http_resp['results'] = $this->suppliers->transform_purchase_order($po);
        return response()->json($http_resp);
    }
    
}

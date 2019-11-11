<?php

namespace App\Http\Controllers\Api\Product\Purchase;

use App\helpers\HelperFunctions;
use App\Models\Practice\Department;
use App\Models\Practice\Inventory\PracticeAccountHolder;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeDepartment;
use App\Models\Practice\PracticeProductItem;
use App\Models\Practice\PracticeStore;
use App\Models\Product\ProductPaymentMethod;
use App\Models\Product\Purchase\ProductPurchase;
use App\Models\Product\Sales\ProductPriceRecord;
use App\Models\Supplier\Supplier;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use App\Repositories\Supplier\SupplierRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Accounts\AccountingRepository;
use App\Models\Account\Banks\AccountsBank;
use App\Models\Account\Vendors\AccountVendor;
use App\Models\NotificationCenter\MailBox;
use PHPUnit\Framework\Constraint\Exception;
use App\Models\Product\Purchase\ProductPo;
use App\Models\Practice\PracticeUser;
use App\Models\Product\Inventory\Inward\ProductStockInward;
use App\Models\Product\Inventory\ProductStock;
use App\Models\Product\Product;
use App\Models\Product\Purchase\PoMovementStatus;
use App\Models\Product\Purchase\ProductPoItem;
use App\Models\Product\Store\ProductStore;
use App\Repositories\ModelRepository;

class POController extends Controller
{
    protected $productPurchase;
    protected $http_response;
    protected $helper;
    protected $practice;
    protected $supplier;
    protected $practice_department;
    protected $department;
    protected $practice_product_item;
    protected $product_pricing;
    protected $banks;
    protected $accountingRepository;
    protected $purchaseOrders;
    protected $purchaseOrderItems;
    protected $practiceUser;
    protected $productStore;
    protected $productStocks;
    protected $productItems;

    public function __construct(ProductPurchase $productPurchase)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productPurchase = new ProductReposity($productPurchase);
        $this->practice = new PracticeRepository(new Practice());
        $this->supplier = new SupplierRepository(new AccountVendor);
        $this->practice_department = new PracticeRepository(new PracticeDepartment());
        $this->department = new PracticeRepository(new Department());
        $this->practice_product_item = new ProductReposity(new PracticeProductItem());
        $this->product_pricing = new ProductReposity(new ProductPriceRecord());
        $this->banks = new AccountingRepository(new AccountsBank());
        $this->accountingRepository = new AccountingRepository(new AccountVendor());
        $this->purchaseOrders = new ProductReposity(new ProductPo());
        $this->practiceUser = new PracticeRepository(new PracticeUser());
        $this->purchaseOrderItems = new ProductReposity(new ProductPoItem());
        $this->productStore = new ProductReposity( new ProductStore() );
        $this->productStocks = new ProductReposity( new ProductStock() );
        $this->productItems = new ProductReposity( new PracticeProductItem() );
        //$this->mails_schedulers = new ModelRepository(new MailScheduler());
    }

    public function index($facility_id = null){

        $http_resp = $this->http_response['200'];
        $data['id'] = "12345";
        $data['status'] = "Pending approval";
        $data['shipping_address'] = "";
        $data['billing_address'] = "";
        $data['po_date'] = "";
        $data['po_due_date'] = "";
        $data['msg_to_supplier'] = "";
        $data['memo'] = "";
        $data['sub_total'] = 400000;
        $data['total'] = 400000;
        $items['id'] = "328cabf8-9b17-48c2-b4b7-251d07287bc1";
        $items['qty'] = 200;
        $items['rate'] = 50;
        $item[0] = $items;
        $item[1] = $items;
        $data['items'] = $item;
        $fac['id'] = "328cabf8-9b17-48c2-b4b7-251d07287bc1";
        $fac['name'] = "AMREF Westlands";
        $data['facility'] = $fac;
        $sup['id'] = "12";
        $sup['name'] = "Alex";
        $sup['email'] = "alex@gsk.com";
        $sup['company'] = "GSK";
        $data['supplier'] = $sup;
        $http_resp['results'] = $data;

        return response()->json($http_resp);
    }

    public function create(Request $request, $source_type=null){

        $http_resp = $this->http_response['200'];

        $rule1 = [
            'source_type'=>'required',
        ];
        $validation = Validator::make($request->all(),$rule1, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        if($request->source_type=="app"){
            $rule2 = [
                'facility_id'=>'required',
                'cart_items'=>'required',
                'quantities'=>'required',
            ];
        }else{
            $rule2 = [
                'practice_id'=>'required',
                'delivery_id'=>'required',
                'memo'=>'required',
                'message'=>'required',
                'practice_id'=>'required',
                'supplier_id'=>'required',
                'facility_id' => 'required',
                'staff_id' => 'required',
                'po_date'=>'required',
                'po_due_date'=>'required',
            ];
        }

        $validation = Validator::make($request->all(),$rule2, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{

            if( $request->source_type == "app" ){
                // Log::info($request);
                $practice = $this->practice->findByUuid($request->facility_id);
                $quantities = json_decode($request->quantities);
                $cart_items = json_decode($request->cart_items);
                for( $s=0; $s<sizeof($quantities); $s++ ){
                    $product_item = $this->productItems->find($cart_items[$s]);
                }
                $practice = $this->practice->findByUuid($request->facility_id);
                $accounts = array();
                $practice_user = $this->practiceUser->findByUserIdPracticeId($request->user()->id, $practice->id,$request->user()->email);
                $acca['account_type'] = PracticeUser::USER_TYPE;
                $acca['data'] = $this->practice->transform_user($practice_user,$request->source_type);
                array_push($accounts,$acca);
                return response()->json($http_resp);

                // $practice = $this->practice->findByUuid($request->facility_id);
                // $practiceParent = $this->practice->findParent($practice);
                // $practiceMain = $this->practice->findParent($practice);
                // $delivery_facility = $this->practice->findByUuid($request->facility_id);
                // $items = json_decode($request->items);
                // $items_array = array();

                // $inputs = $request->all();
                // // $inputs['supplier_id'] = $supplier->id;
                // $purchase_order = $practiceParent->purchase_orders()->create($inputs); //Enterprise;
                // $purchase_order = $practice->purchase_orders()->save($purchase_order); //Facility Creating;
                // $purchase_order = $delivery_facility->delivered_locations()->save($purchase_order);//Facility Where to deliver;
                // $status = $request->all();
                // $status['status'] = "Pending";
                // $purchase_order->statuses()->create($status);

                // for( $j=0; $j < sizeof($items); $j++ ){
                //     $pract_prod_item = $this->practice_product_item->findByUuid($items[$j]->item_id);
                //     $price = $pract_prod_item->price_record()->get()->last();
                //     // $price = $this->product_pricing->createPrice($pract_prod_item->id,
                //     //             $practice->id,$pract_prod_item->unit_cost,$pract_prod_item->unit_retail,
                //     //             $pract_prod_item->pack_cost,$pract_prod_item->pack_retail,$request->user()->id);
                //     $item_inputs = [
                //         'po_id'=>$purchase_order->id,
                //         'qty'=>$items[$j]->qty,
                //         // 'description'=>$items[$j]['description'],
                //         'product_price_id'=>$price->id,
                //         'product_item_id'=>$pract_prod_item->id,
                //     ];
                //     array_push($items_array,$item_inputs);
                // }
                // $purchase_order->items()->insert($items_array);
                // DB::commit();
                // $http_resp['results'] = $this->helper->format_purchase_order($purchase_order);
                return response()->json($http_resp);
            }

            $practice = $this->practice->findByUuid($request->practice_id); //Facility creating PO
            $delivery_facility = $this->practice->findByUuid($request->delivery_id); //Facility creating PO
            
            $practiceParent = $this->practice->findParent($practice); //Facility where to deliver PO
            $practiceMain = $this->practice->findOwner($practice); //Main Facility

            $supplier = $this->supplier->findByUuid($request->supplier_id);
            $inputs = $request->all();
            $inputs['supplier_id'] = $supplier->id;
            $inputs['status'] = 'Pending Approval';
            $purchase_order = $practiceParent->purchase_orders()->create($inputs); //Enterprise;
            $purchase_order->trans_number = "PO".$purchase_order->id;
            $purchase_order = $practice->purchase_orders()->save($purchase_order); //Facility Creating;
            $purchase_order = $delivery_facility->delivered_locations()->save($purchase_order);//Facility Where to deliver;
            $items = $request->items;
            $items_array = array();
            for( $j=0; $j < sizeof($items); $j++ ){

                if($items[$j]['qty'] < 1){
                    DB::rollBack();
                    Log::info("PO Item with zero quantity");
                    $http_resp = $this->http_response['422'];
                    $http_resp['errors'] = ["Purchase Order Item with zero quantity detected!"];
                    return response()->json($http_resp,422);
                }
                $pract_prod_item = $this->practice_product_item->findByUuid($items[$j]['id']);
                $price = $this->product_pricing->createPrice($pract_prod_item->id,
                            $practice->id,$items[$j]['unit_cost'],$items[$j]['unit_retail'],
                            $items[$j]['pack_cost'],$items[$j]['pack_retail'],$request->user()->id);
                            $item_inputs = [
                                'po_id'=>$purchase_order->id,
                                'qty'=>$items[$j]['qty'],
                                'description'=>$items[$j]['description'],
                                'product_price_id'=>$price->id,
                                'product_item_id'=>$pract_prod_item->id,
                            ];
                            array_push($items_array,$item_inputs);
            }
            $purchase_order->items()->insert($items_array);
            switch($request->action_taken){

                case "Save & Send": //setting approved by
                    $staff = $this->practiceUser->findByUuid($request->staff_id);
                    $status = $request->all();
                    $status['status'] = Product::STATUS_SUBMITTED;
                    $purchase_order->statuses()->create($status);
                    //Update ProductPo Status
                    $purchase_order->status = Product::STATUS_SUBMITTED;
                    $purchase_order->save();
                    $purchase_order = $staff->purchase_orders_approvals()->save($purchase_order);
                    $mailing_address = $this->helper->format_supplier($supplier);
                    $shipping_address = $this->practice->transform_($practice);
                    //$shipping_address['logo'] = $this->helper->encode_image();
                    $order_data = $this->helper->format_purchase_order($purchase_order);
                    //Schedule mail
                    $mailing_address['subject'] = MailBox::PO_SUBJECT;
                    $mailing_address['msg'] = MailBox::PO_MSG;
                    //$this->helper->sendOrders($mailing_address,$shipping_address,$order_data,MailBox::PO_SUBJECT);
                    $mailbox = $practiceParent->product_email_notifications()->create($mailing_address);
                    $mailbox = $practice->product_email_notifications()->save($mailbox);
                    $attachment = $mailbox->attatchments()->create(['attachment_type'=>MailBox::PO_SUBJECT]);
                    $attachment = $purchase_order->mails_attachments()->save($attachment);
                    break;
                case "Save & Forward":

                    break;

            }
            $http_resp['description'] = "Purchase Order placed successful!";

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            $http_resp['description'] = "Request failed due to internal server error. Please try again later";
            Log::info($e);
            DB::rollBack();
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function grn(Request $request){

        $http_resp = $this->http_response['200'];
        $rule = [
            'po_number'=>'required',
            'branch_id'=>'required',
            'date_received'=>'required',
            'store_id' => 'required',
            'department_id' => 'required',
            'items' => 'required',
            'accounts_copy'=>'required',
            'supplier_copy'=>'required',
            'store_copy'=>'required',
        ];
        //return;
        $validation = Validator::make($request->all(),$rule, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        //Change status to delivered
        //set charged location
        //Also in Pending Stock: (Insert into product_stocks with initial status "Pending")
        DB::beginTransaction();
        try{
            //$practice_to_pay = $this->practice->findByUuid($request->cost_centre_id);
            $practice = $this->practice->findByUuid($request->branch_id);//Facility where this is being received
            $practiceParent = $this->practice->findParent($practice);//Enterprise
            $store = $this->productStore->findByUuid($request->store_id);//Store
            $department = $this->department->findByUuid($request->department_id);//Department
            $substore = $this->productStore->findByUuid($request->sub_store_id);//Substore
            $practiceUser = $this->practiceUser->findByUuid($request->staff_id);//User receiving
            $purchase_order = $this->purchaseOrders->findByUuid($request->id);//Po
            // $status = $purchase_order->statuses()->where('status',Product::STATUS_DELIVERED)->get()->first();//Check if Delivered and ignore
            // if($status){
            //     $http_resp = $this->http_response['422'];
            //     $http_resp['errors'] = ["PO was delivered on ".$this->helper->format_mysql_date($purchase_order->updated_at)];
            //     return response()->json($http_resp,422);
            // }
            $purchase_order = $practiceUser->product_po()->save($purchase_order);//user who received
            $status_inputs['status']=Product::STATUS_DELIVERED;//Status will be delivered if ordered Items(qty) is delivered(qty)
            //$delivery_status = PoMovementStatus::create($status_inputs);
            //Create GRN Note Here: grn_notes
            $grn_inputs = $request->all();
            $grn_inputs['transaction_type'] = MailBox::PO_SUBJECT;
            $grn_note = $purchase_order->grn_notes()->create($grn_inputs); //create grn note
            $grn_note->trans_number = "GRN".$grn_note->id;
            $grn_note = $practice->grn_deliverylocation()->save($grn_note ); //Facility where it was delivered
            $grn_note = $store->grn_store_notes()->save($grn_note ); //store where it was delivered
            $grn_note = $department->grn_notes()->save($grn_note ); //Department where
            $grn_note = $practiceUser->grn_receivedby()->save($grn_note ); //Received By
            $grn_note = $practiceUser->grn_checkedby()->save($grn_note ); //Checked By
            if($substore){
                $grn_note = $substore->grn_sub_store_notes()->save($grn_note ); //store where it was delivered
            }
            //Get PO Items
            $items = $request->items;
            $general_status = Product::STATUS_DELIVERED;
            $less_delivery = 0;
            $actual_delivery = 0;
            $exces_delivery = 0;
            for( $j=0; $j < sizeof($items); $j++ ){

                $po_item = $this->purchaseOrderItems->find($items[$j]['po_item_id']); //PO items
                //Check if in ordered items list, there is an item which is not delivered
                if($items[$j]['delivered_qty'] != "" || $items[$j]['delivered_qty'] > 0){ //this item is delivered
                    //---------------------------------------------------------------------------------------------
                    //$po_item = $purchase_order->items()->get()->first(); //items
                    //Log::info($po_item);
                    $pract_prod_item = $po_item->product_items()->get()->first();
                    $price = $this->product_pricing->createPrice($pract_prod_item->id,
                    $practice->id,$items[$j]['unit_cost'],$items[$j]['unit_retail'],
                    $items[$j]['pack_cost'],$items[$j]['pack_retail'],$request->user()->id);
                    $item_inputs = $request->all();
                    //Create a GRN Item
                    $item_inputs = [
                        'amount'=>$items[$j]['delivered_qty'],
                        'comment'=>$items[$j]['comment'],
                        'source_type' => ProductStockInward::STOCK_SOURCES_PURCHASE_ORDER,
                        'status' => Product::STATUS_PENDING,
                        'description'=>$items[$j]['description'],
                        'product_item_price_id'=>$price->id,
                        'product_item_id'=>$pract_prod_item->id,
                    ];
                    $product_stock = $this->productStocks->create($item_inputs);
                    //stock sourceable: Stock came in as a result of PO
                    $product_stock = $purchase_order->product_stocks()->save($product_stock);
                    //stock owner: Enterprice
                    $product_stock = $practiceParent->product_stocks()->save($product_stock);
                    //Stock Owning: Facility where stock was delivered
                    $product_stock = $practice->product_stocks()->save($product_stock);
                    //Department that received stock
                    $product_stock = $department->product_stocks()->save($product_stock);
                    //Store that receiced stock
                    $product_stock = $store->product_stocks()->save($product_stock);
                    //Sub store that received stock
                    if($substore){
                        $product_stock = $substore->product_sub_stocks()->save($product_stock);
                    }
                    //Create GRN Delivered Item
                    $grn_item = $grn_note->grn_items()->create($item_inputs);
                    $grn_item = $pract_prod_item->grn_note_items()->save($grn_item);
                    //---------------------------------------------------------------------------------------------
                    //Check if any item is delivered less
                    if( $po_item->qty < $items[$j]['delivered_qty'] ){ //Check if Item delivered was Excess
                        $po_item->status = Product::STATUS_EXCESS_DELIVERED;
                        $exces_delivery += 1;
                    }elseif($po_item->qty > $items[$j]['delivered_qty']){ //Check if Item delivered was in less
                        $po_item->status = Product::STATUS_LESS_DELIVERED;
                        $less_delivery += 1;
                    }else{ //Item was delivered in full(Actual)
                        $po_item->status = Product::STATUS_DELIVERED;
                        $actual_delivery += 1;
                    }
                    //Update PO Item status based on what was delivered
                    $po_item->save();
                    //Link this PO Item to GRNNoteItem
                    $owner_is = $grn_item->owner()->save($po_item);
                    //---------------------------------------------------------------------------------------------
                }
            }
            //Save PO Status based on what was delivered
            if($less_delivery){
                $general_status = Product::STATUS_LESS_DELIVERED;
            } elseif ($exces_delivery) {
                $general_status = Product::STATUS_EXCESS_DELIVERED;
            }
            $status_inputs['status']=Product::STATUS_DELIVERED;
            $statuses = $purchase_order->statuses()->create($status_inputs); //Final Status
            //Also ProductPo Table Status
            $purchase_order->status = $general_status;
            $purchase_order->save();
            //Prepare return response
            $http_resp['results'] = $statuses->status;
            $http_resp['description'] = "Successful Received!";
            $http_resp['description'] = $status_inputs['status'];
            //PERFORM ACCOUNTING TRANSACTIONS HERE
            //SCHEDULE MAILS HERE
            $mailing_address['subject'] = MailBox::GRN_SUBJECT;
            $mailing_address['msg'] = MailBox::GRN_MSG;
            if($request->accounts_copy){ //Send Accounts Finance a Copy
                //Schedule mail
                // $mailing_address['subject'] = MailBox::GRN_SUBJECT;
                // $mailing_address['msg'] = MailBox::PO_MSG;
                $mailing_address['email'] = 'accountant@amref.com';
                //$this->helper->sendOrders($mailing_address,$shipping_address,$order_data,MailBox::PO_SUBJECT);
                $mailbox = $practiceParent->product_email_notifications()->create($mailing_address);
                $mailbox = $practice->product_email_notifications()->save($mailbox);
                $attachment = $mailbox->attatchments()->create(['attachment_type'=>MailBox::GRN_SUBJECT]);
                $attachment = $grn_note->mails_attachments()->save($attachment);
            }
            if($request->supplier_copy){ //Send Supplier a copy Finance a Copy
                //Schedule mail
                // $mailing_address['subject'] = MailBox::GRN_SUBJECT;
                // $mailing_address['msg'] = MailBox::PO_MSG;
                $mailing_address['email'] = $request->supplier['email'];
                //$this->helper->sendOrders($mailing_address,$shipping_address,$order_data,MailBox::PO_SUBJECT);
                $mailbox = $practiceParent->product_email_notifications()->create($mailing_address);
                $mailbox = $practice->product_email_notifications()->save($mailbox);
                $attachment = $mailbox->attatchments()->create(['attachment_type'=>MailBox::GRN_SUBJECT]);
                $attachment = $grn_note->mails_attachments()->save($attachment);
            }
            if($request->store_copy){ //Send Accounts Finance a Copy
                //Schedule mail
                $mailing_address['email'] = 'storemanager@amref.com';
                //$this->helper->sendOrders($mailing_address,$shipping_address,$order_data,MailBox::PO_SUBJECT);
                $mailbox = $practiceParent->product_email_notifications()->create($mailing_address);
                $mailbox = $practice->product_email_notifications()->save($mailbox);
                $attachment = $mailbox->attatchments()->create(['attachment_type'=>MailBox::GRN_SUBJECT]);
                $attachment = $grn_note->mails_attachments()->save($attachment);
            }
        }catch(\Exception $ex){
            $http_resp = $this->http_response['500'];
            $http_resp['description'] = "Request failed due to internal server error. Please try again later";
            Log::info($ex);
            DB::rollBack();
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function update(Request $request, $uuid){}
    public function delete($uuid){}

    public function show($uuid){
        $http_resp = $this->http_response['200'];
        $data['id'] = "12345";
        $data['status'] = "Pending approval";
        $data['shipping_address'] = "";
        $data['billing_address'] = "";
        $data['po_date'] = "";
        $data['po_due_date'] = "";
        $data['msg_to_supplier'] = "";
        $data['memo'] = "";
        $data['sub_total'] = 400000;
        $data['total'] = 400000;
        $items['id'] = "328cabf8-9b17-48c2-b4b7-251d07287bc1";
        $items['qty'] = 200;
        $items['rate'] = 50;
        $item[0] = $items;
        $item[1] = $items;
        $data['items'] = $item;
        $fac['id'] = "328cabf8-9b17-48c2-b4b7-251d07287bc1";
        $fac['name'] = "AMREF Westlands";
        $data['facility'] = $fac;
        $sup['id'] = "12";
        $sup['name'] = "Alex";
        $sup['email'] = "alex@gsk.com";
        $sup['company'] = "GSK";
        $data['supplier'] = $sup;
        $http_resp['results'] = $data;
        return response()->json($http_resp);
    }

    public function facility($facility_id){
        $http_resp = $this->http_response['200'];
        $results = array();
        $practice = $this->practice->findByUuid($facility_id);
        $purchases = $practice->purchase_orders()->orderByDesc('created_at')->paginate(10);
        //Log::info($purchases);
        foreach($purchases as $purchas){
            array_push($results,$this->helper->format_purchase_order($purchas));
        }
        $paged_data = $this->helper->paginator($purchases);
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

}

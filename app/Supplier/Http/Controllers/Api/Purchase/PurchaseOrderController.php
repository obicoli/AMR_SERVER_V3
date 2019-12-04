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
        // $this->suppliers = new SupplierRepository( new Supplier() );
        // $this->accountingVouchers = new AppAccountingRepository(new AccountsVoucher());
        // $this->countries = new AppAccountingRepository( new Country() );
        // $this->paymentTerms = new SupplierRepository( new SupplierTerms() );
        // $this->supplierCompanies = new SupplierRepository( new SupplierCompany() );
    }

    public function index(Request $request){

        $http_resp = $this->http_response['200'];
        $company = $this->practices->find($request->user()->company_id);
        //Log::info($request);
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

        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->beginTransaction();
        try{

            if( $request->has("status_action") ){
                $inputs = $request->all();
                $inputs['notes'] = "Purchase Order marked as ".$inputs['status'];
                //Find the Purchase Order By uuid
                $po = $this->purchaseOrders->findByUuid($uuid);
                //Find Company User
                $company_user = $this->company_users->find($request->user()->company_id); //Get current user
                //Insert into PO status Table
                $po_status = $company_user->po_status()->create($inputs);
                $est_status = $po->po_status()->save($po_status);
                
            }

        }catch( \Exception $e ){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->commit();
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
            $status ['status'] = Product::STATUS_DRAFT;
            if( $request->has("action_taken") ){
                switch ($request->action_taken) {
                    case Product::ACTIONS_SAVE_DRAFT:
                        //$status = [ 'status'=>Product::STATUS_DRAFT ];
                        $status ['status'] = Product::STATUS_DRAFT;
                        break;
                    case Product::ACTIONS_SAVE_SEND :
                        //$status = [ 'status'=>Product::STATUS_OPEN ];
                        $status ['status'] = Product::STATUS_OPEN;
                        //Schedule this Email to be Send
                        //Schedule mail
                        $mailing_address['subject'] = MailBox::PO_SUBJECT;
                        $mailing_address['msg'] = MailBox::PO_MSG;
                        $mailbox = $practiceParent->product_email_notifications()->create($mailing_address);
                        $mailbox = $company->product_email_notifications()->save($mailbox);
                        $attachment = $mailbox->attatchments()->create(['attachment_type'=>MailBox::PO_SUBJECT]);
                        $attachment = $new_po->mails_attachments()->save($attachment);
                        break;
                }
            }
            //Create the status  and attach it the user responsible
            //Then attach it to estimate
            $po_status = $company_user->po_status()->create($status);
            $est_status = $new_po->po_status()->save($po_status);
            $new_po->status = $status['status']; 

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
                $po_item = $new_po->items()->create($item_inputs);
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

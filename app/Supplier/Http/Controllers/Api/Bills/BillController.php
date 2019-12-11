<?php

namespace App\Supplier\Http\Controllers\Api\Bills;

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
use App\Supplier\Models\SupplierBill;

class BillController extends Controller
{
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $supplierBills;
    protected $purchaseOrders;
    protected $productItems;
    protected $suppliers;
    protected $customers;
    protected $company_users;
    protected $product_pricing;
    protected $productTaxations;

    public function __construct( SupplierBill $supplierBill )
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice() );
        $this->supplierBills = new SupplierRepository( $supplierBill );
        $this->productItems = new ProductReposity( new ProductItem() );
        $this->suppliers = new SupplierRepository( new Supplier() );
        $this->customers = new CustomerRepository( new Customer() );
        $this->company_users = new PracticeRepository(new PracticeUser());
        $this->product_pricing = new ProductReposity(new ProductPriceRecord());
        $this->productTaxations = new ProductReposity( new ProductTaxation() );
        $this->purchaseOrders = new SupplierRepository( new PurchaseOrder() );
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $company = $this->practices->find($request->user()->company_id);
        $bill_lists = $company->supplier_bills()->orderByDesc('created_at')->paginate(15);
        $results = array();
        foreach($bill_lists as $bill_list){
            array_push( $results,$this->supplierBills->transform_bill($bill_list) );
        }
        $paged_data = $this->helper->paginator($bill_lists);
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function create(Request $request){
        Log::info($request);
        $http_resp = $this->http_response['200'];
        $rule = [
            'bill_date'=>'required',
            'bill_due_date'=>'required',
            'supplier_id'=>'required',
            'notes'=>'required',
            'taxation_option'=>'required',
            //'billable_type'=>'required',
            //'order_number'=>'required',
            'bill_type'=>'required',
            'items'=>'required',
            'total_bill'=>'required',
            'total_grand'=>'required',
            'total_tax'=>'required',
            'discount_offered'=>'required',
        ];
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        if( $request->bill_type == Product::DOC_CASH_BILL ){
            $rule = [
                'bank_account'=>'required',
            ];
            $validation = Validator::make($request->all(),$rule,$this->helper->messages());
            if ($validation->fails()){
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                return response()->json($http_resp,422);
            }
        }

        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        try{
            //Create new bill
            $company = $this->practices->find($request->user()->company_id);
            $practiceParent = $this->practices->findParent($company);
            $supplier = $this->suppliers->findByUuid($request->supplier_id);
            $company_user = $this->company_users->find($request->user()->company_id); //Get current user
            $inputs = $request->all();
            $inputs['supplier_id'] = $supplier->id; //Link bill to supplier
            $new_bill = $this->supplierBills->create($inputs);
            //Generate and update Transaction number
            $new_bill->trans_number = $this->helper->create_transaction_number("BL",$new_bill->id);
            $new_bill->save();
            //Link this bill to a company
            $new_bill = $company->supplier_bills()->save($new_bill);
            //Status
            $status = [ 'status'=>Product::STATUS_DRAFT ];
            if($request->order_number){ //Bill is being created from an Order
                if($request->billable_type === "PO"){
                    $purchase_order = $this->purchaseOrders->findByTransNumber($request->order_number);
                    //$purchase_order = $new_bill->billed()->save($new_bill);
                    //$new_bill = $new_bill->billed()->save($purchase_order);
                    //Link it to Billed id and Type
                    $new_bill = $purchase_order->bills()->save($purchase_order);
                    // $new_bill->billed_id = $purchase_order->id;
                    // $new_bill->billed_type = "App\Supplier\Models\PurchaseOrder";
                    // $new_bill->save();
                    //Make PO Status to Closed
                    $po_state = [
                        'status'=>Product::STATUS_CLOSED,
                        'notes'=>"Purchase Order marked as closed"
                    ];
                    $po_status = $company_user->po_status()->create($po_state);
                    $po_status = $purchase_order->po_status()->save($po_status);
                    //
                    $status['notes'] = "Bill raised for the Purchase Order ".$purchase_order->trans_number;
                }
            }
            //
            if( $request->has("action_taken") ){
                switch ($request->action_taken) {
                    case Product::ACTIONS_SAVE_DRAFT:
                        $status = [ 'status'=>Product::STATUS_DRAFT ];
                        break;
                    case Product::ACTIONS_SAVE_OPEN :
                        $status = [ 'status'=>Product::STATUS_OPEN ];
                        break;
                }
                //Create the status  and attach it the user responsible
                //Then attach it to estimate
                $bill_status = $company_user->bill_status()->create($status);
                $bill_status = $new_bill->bill_status()->save($bill_status);
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
                    'supplier_bill_id'=>$new_bill->id,
                    'qty'=>$items[$j]['qty'],
                    'product_price_id'=>$price->id,
                    'product_item_id'=>$product_item->id,
                ];
                $bill_item = $new_bill->items()->create($item_inputs);
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
                        'bill_item_id'=>$bill_item->id,
                    ];
                    $item_taxation = DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->table('bill_item_taxations')->insert($tax_inputs);
                }
            }

        }catch( \Exception $e ){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
        return response()->json($http_resp);

    }

}

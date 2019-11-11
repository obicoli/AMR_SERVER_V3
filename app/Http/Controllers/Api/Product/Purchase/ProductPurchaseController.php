<?php

namespace App\Http\Controllers\Api\Product\Purchase;

use App\Assets\Helpers\AssetsHelper;
use App\helpers\HelperFunctions;
use App\Hrs\Helpers\HrsHelper;
use App\Hrs\Models\Employee\HrsJob;
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
use App\Models\Product\Store\ProductStore;
use App\Models\Account\Payments\AccountPaymentType;
use App\Models\Account\Payments\AccountPaymentMethod;
use App\Models\Account\COA\AccountChartAccount;
use App\Models\Product\ProductSupplier;

class ProductPurchaseController extends Controller
{
    protected $productPurchase;
    protected $http_response;
    protected $helper;
    protected $hrs_helper;
    protected $assets_helper;
    protected $practice;
    protected $supplier;
    protected $practice_department;
    protected $department;
    protected $stores;
    //protected $payment_method;
    protected $practice_product_item;
    protected $product_pricing;
    protected $banks;
    protected $accountSupplier;
    protected $accountPaymentType;
    protected $accountPaymentMethod;
    protected $chartofAccounts;

    public function __construct()
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        // $this->productPurchase = new ProductReposity($productPurchase);
        $this->practice = new PracticeRepository(new Practice());
        // $this->supplier = new SupplierRepository(new Supplier());
        // $this->practice_department = new PracticeRepository(new PracticeDepartment());
        // $this->department = new PracticeRepository(new Department());
        // $this->stores = new PracticeRepository(new ProductStore());
        //$this->payment_method = new ProductReposity(new ProductPaymentMethod());
        // $this->practice_product_item = new ProductReposity(new PracticeProductItem());
        // $this->product_pricing = new ProductReposity(new ProductPriceRecord());
        // $this->banks = new AccountingRepository(new AccountsBank());
        //$this->accountSupplier = new AccountingRepository(new AccountVendor());
        // $this->accountPaymentType = new AccountingRepository(new AccountPaymentType());
        // $this->accountPaymentMethod = new AccountingRepository(new AccountPaymentMethod());
        // $this->chartofAccounts = new AccountingRepository(new AccountChartAccount());
        // $this->hrs_helper = new HrsHelper();
        // $this->assets_helper = new AssetsHelper();
    }

    public function index($facility_id = null){
        $http_resp = $this->http_response['200'];
        $results = array();
        if($facility_id){
            $practice = $this->practice->findByUuid($facility_id);
            $purchases = $this->productPurchase->getPurchases($practice);
            $response = $this->helper->paginator($purchases);
            foreach ($purchases as $purchase) {
                array_push($results, $this->productPurchase->transform_purchase($purchase));
            }
            $response['data'] = $results;
        }
        $http_resp['results'] = $response;
        return response()->json($http_resp);
    }

    public function store(Request $request){
        Log::info($request);
        $http_resp = $this->http_response['200'];
        $rules = [
            'practice_id' => 'required',
            //'supplier_id' => 'required',
            //'department_id' => 'required',
            //'store_id' => 'required',
            'total_bill' => 'required',
            'total_grand' => 'required',
            'items' => 'required',
            'purchase_type' => 'required',
            //'discount_offered' => 'required',
            //'payment_date' => 'required',
        ];

        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{

            $practice = $this->practice->findByUuid($request->practice_id);
            $practiceParent = $this->practice->findParent($practice);
            switch($request->purchase_type){

                case "purchase":
                    $inputs = $request->all();
                    $supplier = $this->accountSupplier->findByUuid($request->supplier_id);
                    $inputs['supplier_id'] = $supplier->id;
                    $practice = $this->practice->findByUuid($request->practice_id);
                    $store = $this->stores->findByUuid($request->store_id);
                    $sub_store = $this->stores->findByUuid($request->sub_store_id);
                    $inputs['store_id'] = $store->id;
                    $inputs['sub_store_id'] = $sub_store->id;
                    $payment_type = $this->accountPaymentType->findByName($request->payment_method_id);
                    $inputs['payment_type_id'] = $payment_type->id;
                    $inputs['status'] = 'Delivered';
                    $purchase = $practiceParent->purchases()->create($inputs);
                    $purchase = $practice->purchases()->save($purchase);
                    //$payment_method = $this->accountPaymentMethod->findByName($request->payment_method_id);
                    if($payment_type->name =="Cheque"){
                        $bank = $this->banks->findByUuid($request->practice_bank_id);
                    }elseif($payment_type->name =="Cash"){
                        $total_bill = $request->total_grand;
                        $cash_paid = $request->cash_paid;
                        $cash_paid = $request->cash_paid;
                    }
                    //create the payment:
                    $inputs2 = [
                        'payment_type_id' => $payment_type->id,
                        'amount' => $request->cash_paid,
                        'status' => 'pending',
                    ];
                    $payment = $purchase->payments()->create($inputs2);
                    $payment = $practice->payments()->save($payment);
                    $payment = $practiceParent->payments()->save($payment);
                    //Accounting Balancing(Pending...)
                    //Itemizing
                    //create purchase items:
                    for ( $j=0; $j<sizeof($request->items); $j++ ){
                        //get the pricing or create new if changed
                        $pract_prod_item = $this->practice_product_item->findByUuid($request->items[$j]['id']);
                        $price = $this->product_pricing->createPrice($pract_prod_item->id,
                            $practice->id,$request->items[$j]['unit_cost'],$request->items[$j]['unit_retail'],
                            $request->items[$j]['pack_cost'],$request->items[$j]['pack_retail'],$request->user()->id);

                        $item_inputs = [
                            // 'practice_id' => $practice->id,
                            'product_purchase_id' => $purchase->id,
                            'product_price_id' => $price->id,
                            'practice_product_item_id' => $pract_prod_item->id,
                            //'payment_method_id' => $pract_prod_item->id,
                            'payment_method_id' => 1,
                            'qty' => $request->items[$j]['qty'],
                            'batch_number' => $request->items[$j]['batch_number'],

                            // 'man_month' => $request->items[$j]['man_month'],
                            // 'man_year' => $request->items[$j]['man_year'],
                            'exp_month' => $request->items[$j]['exp_month'],
                            'exp_year' => $request->items[$j]['exp_year'],

                            'status' => 'Delivered',
                        ];
                        $item = $purchase->items()->create($item_inputs);
                    }
                    break;
                case "rpo":
    
                    break;
                case "lpo":
    
                    break;
            }

            //$supplier = $this->supplier->findByUuid($request->supplier_id);
            //$supplier = $this->accountHolder->findByUuid($request->supplier_id);
            //$practice_department = $this->practice_department->findByUuid($request->department_id);
            //$department = $this->department->find($practice_department->department_id);
            //$store = $this->stores->findByUuid($request->store_id);
            //cooked, to be corrected
            //$payment_method = $this->payment_method->findByName($request->payment_method_id);
            //$payment_method = $this->payment_method->findByName($request->payment_method_id);

            // //create purchase: save purchase
            // $inputs = $request->except(['items','practice_bank_id','cheque_number','cash_paid','cash_balance']);
            // if ($request->discount_offered == ""){
            //     $inputs['discount_offered'] = 0;
            // }
            // $inputs['practice_id'] = $practice->id;
            // //$inputs['supplier_id'] = $supplier->id;
            // //$inputs['department_id'] = $department->id;
            // //$inputs['store_id'] = $store->id;
            // $inputs['payment_method_id'] = $payment_method->id;
            // $inputs['status'] = 'Requested';
            //
        }catch (\Exception $exception){
            Log::info($exception);
            DB::rollBack();
            $http_resp = $this->http_response['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function update(Request $request,$uuid){

        $http_resp = $this->http_response['200'];

        DB::beginTransaction();

        try{

            $purchase = $this->productPurchase->findByUuid($uuid);

            switch ($request->action){

                case "Forward":
                    $purchase->status = "Pending Approval";
                    $purchase->save();
                    $http_resp['description'] = "Purchase successful forwarded to procurement";
                    break;
                case "Approve":
                    //changes status to approved
                    $purchase->status = "Approved";
                    $purchase->save();
                    $http_resp['description'] = "Purchase successful approved";
                    break;
                case "Order":
                    //changes status to approved
                    $purchase->status = "Ordered";
                    $purchase->save();
                    $http_resp['description'] = "An order has been placed successful";
                    break;
                case "Receive":
                    $purchase->status = "Received";
                    $purchase->save();
                    $http_resp['description'] = "An order has been received successful";
                break;
            }

        }catch (\Exception $exception){
            Log::info($exception);
            DB::rollBack();
            $http_resp = $this->http_response['500'];
            return response()->json($http_resp,500);
        }

        DB::commit();
        return response()->json($http_resp);

    }

    public function show($uuid){}

    public function destroy($uuid){
        $http_resp = $this->http_response['200'];
        $purchase = $this->productPurchase->findByUuid($uuid);
        $purchase->delete();
        //DB::commit();
        return response()->json($http_resp);
    }

    public function initials(Request $request){

        $http_resp = $this->http_response['200'];
        Log::info($request->user()->company_id);
        $practice = $this->practice->find($request->user()->company_id);
        $practiceParent = $this->practice->findParent($practice);
        $branches = $practiceParent->practices()->get()->sortBy('name');
        $facili = array();
        foreach($branches as $branch){
            array_push($facili,$this->practice->transform_($branch));
        }

        // $storee = array();
        // $subs_store = array();
        // $vehicl = array();
        // $departments = array();
        // $drives = array();
        // $payment_methods = array();

        // //Payment methods
        // $methods_pay = $practiceParent->payment_types()->get();
        // foreach ($methods_pay as $methods_pa) {
        //     array_push($payment_methods,$this->helper->transform_payment_type($methods_pa));
        // }



        // $driver_title = HrsJob::all()->where('job_title','Driver')->first();
        // $drivers = $practice->employees()->where('job_id',$driver_title->id)->get();
        // Log::info($drivers);
        // foreach ($drivers as $driver) {
        //     array_push($drives, $this->hrs_helper->transform_employee($driver));
        // }

        // $vehicles = $practice->vehicles()->get();
        // foreach ($vehicles as $vehicle) {
        //     array_push($vehicl,$this->assets_helper->transform_vehicle($vehicle));
        // }

        // $stores = $this->productPurchase->getStores($practiceParent,'main');
        // foreach($stores as $stor){
        //     array_push($storee,$this->helper->transform_store($stor));
        // }

        // $substores = $this->productPurchase->getStores($practiceParent,'sub store');
        // $substoress = array();
        // foreach($substores as $substore){
        //     array_push($substoress,$this->helper->transform_store($substore));
        // }

        // $payment_typs = $practiceParent->payment_types()->get()->sortBy('name');
        // $payment_types = array();
        // foreach($payment_typs as $payment_typ){
        //     $payment_ty['id'] = $payment_typ->uuid;
        //     $payment_ty['name'] = $payment_typ->name;
        //     array_push($payment_types,$payment_ty);
        // }

        // $departs = $practiceParent->departments()->get()->sortBy('name');
        // foreach($departs as $depart){
        //     $deps['id'] = $depart->uuid;
        //     $deps['name'] = $depart->name;
        //     array_push($departments,$deps);
        // }

        // $suppliers = array();
        // $supplierss = ProductSupplier::all();
        // foreach( $supplierss as $supplier ){
        //     $temp_data['id'] = $supplier->uuid;
        //     $temp_data['title'] = "Mr";
        //     $temp_data['status'] = $supplier->status;
        //     $temp_data['first_name'] = $supplier->first_name;
        //     $temp_data['other_name'] = $supplier->other_name;
        //     $temp_data['mobile'] = $supplier->mobile;
        //     $temp_data['address'] = $supplier->address;
        //     $temp_data['company'] = $supplier->company;
        //     $temp_data['email'] = $supplier->email;
        //     $temp_data['city'] = $supplier->city;
        //     $temp_data['country'] = $supplier->country;
        //     $temp_data['postal_code'] = $supplier->postal_code;
        //     array_push($suppliers,$temp_data);
        // }
        
        $results = array();
        //$results['facilities'] = $facili;

        // $results['stores'] = $storee;
        // $results['departments'] = $departments;
        // $results['sub_stores'] = $substoress;
        //$results['payment_types'] = $payment_types;
        //$results['drivers'] = $drives;
        //$results['vehicles'] = $vehicl;
        //$results['payment_methods'] = $payment_methods;
        //$results['banks'] = $this->banks->getBanks($practiceParent);
        //$results['suppliers'] = $suppliers;
        //$results['suppliers'] = $this->accountSupplier->transform_collection($this->accountSupplier->getVendors($practiceParent,'supplier'),'vendors');
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }

}

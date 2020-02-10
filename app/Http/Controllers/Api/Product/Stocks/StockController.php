<?php

namespace App\Http\Controllers\Api\Product\Stocks;

use App\helpers\HelperFunctions;
use App\Mobile\Repository\MobileRepository;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeProductItem;
use App\Models\Product\Product;
use App\Models\Users\User;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Models\Product\ProductGeneric;
use App\Models\Product\ProductType;
use App\Models\Product\ProductBrand;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductUnit;
use App\Models\Product\ProductAdministrationRoute;
use App\Models\Product\ProductCurrency;
use App\Repositories\Manufacturer\ManufacturerRepository;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Practice\Department;
use App\Models\Product\Inventory\Inward\ProductStockInward;
use App\Models\Product\Inventory\ProductStock;
use App\Models\Product\Inventory\ProductStockTaking;
use App\Models\Product\Store\ProductStore;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{

    protected $product;
    protected $http_response;
    protected $helper;
    protected $practice;
    protected $productItem;
    protected $practiceProductItem;
    protected $productStocks;
    protected $user;
    // protected $manufacturer;
    // protected $item_type;
    // protected $brands;
    // protected $item_category;
    // protected $unit_measure;
    // protected $product_routes;
    // protected $product_currency;
    protected $departments;
    protected $stores;
    protected $productStockTaking;
    protected $product_stock_inward;
    protected $mobileApp;

    public function __construct(Product $product)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->product = new ProductReposity($product);
        $this->practice = new PracticeRepository(new Practice());
        $this->productItem = new ProductReposity(new PracticeProductItem());
        $this->productStocks = new ProductReposity(new ProductStock());
        $this->user = new UserRepository( new User() );
        //$this->http_response = Config::get('response.http');
        //$this->helper = new HelperFunctions();
        $this->practiceProductItem = new ProductReposity(new PracticeProductItem());
        //$this->product = new ProductReposity(new Product());
        // $this->generic = new ProductReposity(new ProductGeneric());
        // $this->manufacturer = new ManufacturerRepository(new Manufacturer());
        // $this->item_type = new ProductReposity(new ProductType());
        // $this->brands = new ProductReposity(new ProductBrand());
        // $this->item_category = new ProductReposity(new ProductCategory());
        // $this->unit_measure = new ProductReposity(new ProductUnit());
        $this->practice = new PracticeRepository(new Practice());
        // $this->product_routes = new ProductReposity(new ProductAdministrationRoute());
        // $this->product_currency = new ProductReposity(new ProductCurrency());
        $this->departments = new PracticeRepository(new Department());
        $this->stores = new ProductReposity(new ProductStore());
        $this->productStockTaking = new ProductReposity( new ProductStockTaking() );
        $this->product_stock_inward = new ProductReposity( new ProductStockInward() );
        $this->mobileApp = new MobileRepository( new User() );
    }

    public function index($practice_id = null,$stock_state="All"){

        $http_resp = $this->http_response['200'];
        $practice = $this->practice->findByUuid($practice_id);
        $transactions = array();
        if($practice){
            switch($stock_state){
                case "All":
                    $product_stock_inward = $practice->product_stock_inward()->orderByDesc('created_at')->paginate(10);
                    $paged_data = $this->helper->paginator($product_stock_inward);
                    foreach($product_stock_inward as $product_stock_inwar){
                        array_push($transactions,$this->helper->transform_stock_inward($product_stock_inwar));
                    }
                    $paged_data['data'] = $transactions;
                    $http_resp['results'] = $paged_data;
                    break;
                case "Pending":
                    $product_stocks = $practice->product_stocks()->orderByDesc('created_at')->paginate(15);
                    $paged_data = $this->helper->paginator($product_stocks);
                    foreach($product_stocks as $product_stock){
                        $instock = $this->helper->transform_stock_item($product_stock);
                        if($instock['stock'] > 0){
                            array_push($transactions,$instock);
                        }
                    }
                    $paged_data['data'] = $transactions;
                    $http_resp['results'] = $paged_data;
                    break;
                case "Expired":
                    $product_stocks = $practice->product_stocks()->orderByDesc('created_at')->paginate(15);
                    $paged_data = $this->helper->paginator($product_stocks);
                    foreach($product_stocks as $product_stock){
                        $instock = $this->helper->transform_stock_item($product_stock);
                        if($instock['stock'] > 0){
                            array_push($transactions,$instock);
                        }
                    }
                    $paged_data['data'] = $transactions;
                    $http_resp['results'] = $paged_data;
                    break;
                case "Recent Expired":
                    $product_stocks = $practice->product_stocks()->orderByDesc('created_at')->paginate(15);
                    $paged_data = $this->helper->paginator($product_stocks);
                    foreach($product_stocks as $product_stock){
                        $instock = $this->helper->transform_stock_item($product_stock);
                        if($instock['stock'] > 0){
                            array_push($transactions,$instock);
                        }
                    }
                    $paged_data['data'] = $transactions;
                    $http_resp['results'] = $paged_data;
                    break;
                case "Low":
                    $practiceParent = $this->practice->findParent($practice);
                    $product_items = $practiceParent->product_items()->paginate(15);
                    Log::info($practiceParent);
                    Log::info($product_items);
                    $paged_data = $this->helper->paginator($product_items);
                    foreach($product_items as $product_item){
                        $stocked = $this->helper->create_product_attribute($product_item,$stock_state);
                        if($stocked['stock'] < $stocked['reorder_level']){
                            array_push($transactions,$stocked);
                        }
                    }
                    $paged_data['data'] = $transactions;
                    $http_resp['results'] = $paged_data;
                    break;
            }
        }
        return response()->json($http_resp);
    }

    public function store(Request $request){

        //Log::info($request);
        $http_resp = $this->http_response['200'];
        $rules = [
            'branch_id'=>'required',
            'store_id'=>'required',
            'department_id'=>'required',
            'items'=>'required',
            'stock_source'=>'required',
        ];
        
        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{

            $practice = $this->practice->findByUuid($request->branch_id);
            $parentPractice = $this->practice->findParent($practice);
            //Department
            $department = $this->departments->findByUuid($request->department_id);
            $store = $this->stores->findByUuid($request->store_id);
            $substore = $this->stores->findByUuid($request->sub_store_id);
            if($request->stock_source == Product::STATUS_PENDING){
                //Log::info();
                $items = $request->items;
                for ($i=0; $i < sizeof($items); $i++) {
                    //Product Stock
                    $productStock = $this->productStocks->findByUuid($items[$i]['id']);
                    //Source of Product Stock
                    $stockSource = $productStock->sourceable()->get()->first();
                    //Product Item
                    $product_item = $productStock->product_items()->get()->first();
                    //Price
                    $price = $productStock->prices()->get()->first();
                    //Check if quantity to be entered is less or equal to pending stock
                    $stock_moved_to_inwards = $productStock->stock_inwards()->sum('amount');
                    $pending_stock = $productStock->amount - $stock_moved_to_inwards;
                    if( ($items[$i]['qty'] <= $pending_stock) && ($items[$i]['stock']>0) ){
                        //Log::info($stockSource);
                        $expire_date = $items[$i]['exp_year']."-".$items[$i]['exp_month']."-01";
                        $expire_date = date('Y-m-d',strtotime($expire_date));
                        //Log::info($expire_date);
                        if( $this->helper->isPastDate($expire_date) ){
                            $http_resp = $this->http_response['422'];
                            $http_resp['expired'] = $productStock->uuid;
                            $http_resp['errors'] = ['Expired stock item detected!'];
                            DB::rollBack();
                            $http_resp['description'] = "Expired";
                            return response()->json($http_resp,422);
                        }else{
                            $inward_inputs = $request->all();
                            $inward_inputs['amount'] = $items[$i]['qty'];
                            $inward_inputs['barcode'] = $items[$i]['barcode'];
                            $inward_inputs['batch_number'] = $items[$i]['batch_number'];
                            $inward_inputs['exp_date'] = $expire_date;
                            $inward_inputs['source_type'] = $productStock->source_type;
                            //
                            $inward = $productStock->stock_inwards()->create($inward_inputs);//create stock inward
                            $inward = $stockSource->product_stock_inward()->save($inward); //set stock source
                            $inward = $parentPractice->product_stock_inward()->save($inward); //Enterprise
                            $inward = $practice->product_stock_inward()->save($inward); //Facility
                            $inward = $department->product_stock_inward()->save($inward); //Department
                            $inward = $store->product_stock_inward()->save($inward); //Store
                            $inward = $product_item->product_stock_inward()->save($inward); //Product Item
                            $inward = $price->product_stock_inward()->save($inward); //Product Item
                            if($substore){
                                $inward = $substore->product_stock_inward_sub_store()->save($inward);
                            }
                        }
                    }
                }
                $http_resp['description'] = "Stock item saved successful!";
            }

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::rollBack();
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function reports(Request $request){
        $http_resp = $this->http_response['200'];
        return response()->json($http_resp);
    }

    public function stock_taking(Request $request){
        Log::info($request);
        $http_resp = $this->http_response['200'];
        $rules = [
            // 'facility_id'=>'required',
            // 'store_id'=>'required',
            'stock_id'=>'required',
            // 'department_id'=>'required',
            // 'sub_store_id'=>'required',
            //'barcode'=>'required',
            'qty'=>'required',
        ];
        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        try{

            // $practice = $this->practice->findByUuid($request->facility_id);
            // $practiceMain = $this->practice->findParent($practice);
            // $department = $this->departments->findByUuid($request->department_id);
            // $store = $this->stores->findByUuid($request->store_id);
            // $sub_store = $this->stores->findByUuid($request->sub_store_id);
            $user = $this->user->findRecord($request->user()->id);

            $practice = $this->practice->find($request->user()->company_id);
            $practiceMain = $this->practice->findParent($practice);
            $department = $this->departments->find($request->user()->department_id);
            $store = $this->stores->find($request->user()->store_id);
            $sub_store = $this->stores->find($request->user()->sub_store_id);

            //Save transaction
            //Enterprise
            $stock_taking = $practiceMain->product_stock_taking()->create($request->all());
            //Facility
            $stock_taking = $practiceMain->product_stock_taking()->save($stock_taking);
            //
            if($department){
                //Department
                $stock_taking = $department->product_stock_taking()->save($stock_taking);
            }
            if($store){
                $stock_taking = $store->product_stock_taking()->save($stock_taking);
            }
            if($sub_store){
                $stock_taking = $sub_store->product_stock_taking_sub_store()->save($stock_taking);
            }
            $http_resp['description'] = "Stock taking was successful!";
            $http_resp['results'] = $this->mobileApp->transformUser($user);

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::rollBack();
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function barcode(Request $request){

        $http_resp = $this->http_response['200'];
        Log::info($request);
        $rules = [
            // 'facility_id'=>'required',
            // 'store_id'=>'required',
            // 'department_id'=>'required',
            // 'sub_store_id'=>'required',
            'barcode'=>'required',
        ];
        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{

            //$product_stock_inw = $this->product_stock_inward->findByUuid($request->barcode);
            // 'barcode' => '8904097385328',
            // 'facility_id' => 'd25b2bfe-f902-4652-8564-c0c62520bec5',
            // 'store_id' => '9c825118-5433-4ef8-8304-6e951d78423c',
            // 'sub_store_id' => 'b090e6ea-1ac0-417e-ab60-070b2443d3b0',
            // 'department_id' => '4c3732b0-a0c5-4098-8cad-6fad5ded9db8',
            
            $practice = $this->practice->find($request->user()->company_id);
            $practiceMain = $this->practice->findParent($practice);
            $department = $this->departments->find($request->user()->department_id);
            $store = $this->stores->find($request->user()->store_id);
            $sub_store = $this->stores->find($request->user()->sub_store_id);
            //--------------
            $product_stock_inward = $practice->product_stock_inward()->where('barcode',$request->barcode)->first();
            $total = $practice->product_stock_inward()->where('barcode',$request->barcode)->sum('amount');
            if($department){
                $product_stock_inward = $department->product_stock_inward()->where('barcode',$request->barcode)->first();
                $total = $department->product_stock_inward()->where('barcode',$request->barcode)->sum('amount');
            }
            if($store){
                $product_stock_inward = $store->product_stock_inward()->where('barcode',$request->barcode)->first();
                $total = $store->product_stock_inward()->where('barcode',$request->barcode)->sum('amount');
            }
            if($sub_store){
                $product_stock_inward = $sub_store->product_stock_inward_sub_store()->where('barcode',$request->barcode)->first();
                $total = $sub_store->product_stock_inward_sub_store()->where('barcode',$request->barcode)->sum('amount');
            }
            $product_stock_inward = $practice->product_stock_inward()->where('barcode',$request->barcode)->first();
            //
            if($product_stock_inward){
                //$product_item = $product_stock_inward->product_items()->get()->first();
//                $item = $this->helper->create_product_attribute($product_item,"Low");
//                $item['stock_total'] = $total;
//                $http_resp['results'] = $item;
                $temp_item['id'] = $product_stock_inward->uuid;
                $temp_item['name'] = 'Zyncet Syrup 60 mls';
                $http_resp['results'] = $temp_item;
            }else{
                $http_resp = $this->http_response['422'];
                Log::info("Wrong Barcode Trying to fetch Item");
                $http_resp['errors'] = ["No Stock Item found!"];
                DB::rollBack();
                return response()->json($http_resp,422);
            }

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::rollBack();
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);

    }
    
}

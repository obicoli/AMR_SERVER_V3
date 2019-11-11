<?php

namespace App\Http\Controllers\Api\Product\Supply;

use App\Assets\Models\Machines\Vehicle\Vehicle;
use App\helpers\HelperFunctions;
use App\Hrs\Models\Employee\HrsEmployee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Account\Payments\AccountPaymentType;
use App\Models\Practice\Department;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeProductItem;
use App\Models\Practice\PracticeUser;
use App\Models\Product\Inventory\Inward\ProductStockInward;
use App\Models\Product\Inventory\Outward\ProductStockSupply;
use App\Models\Product\Product;
use App\Models\Product\Sales\ProductPriceRecord;
use App\Models\Product\Store\ProductStore;
use App\Models\Product\Supply\GoodsOutNote;
use App\Models\Product\Supply\ProductSupply;
use App\Repositories\ModelRepository;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductSupplyController extends Controller
{
    protected $productSupply;
    protected $helper;
    protected $http_response;
    protected $employees;
    protected $vehicles;
    protected $practice;
    protected $stores;
    protected $departments;
    protected $product_pricing;
    protected $practice_product_item;
    protected $product_stock_inwards;
    protected $product_stock_out_supplies;
    protected $accountPaymentType;
    protected $practiceUser;
    protected $goods_out_notes;


    public function __construct(ProductSupply $productSupply)
    {
        $this->productSupply = new ProductReposity($productSupply);
        $this->helper = new HelperFunctions();
        $this->http_response = Config::get('response.http');
        $this->vehicles = new ModelRepository(new Vehicle());
        $this->employees = new ModelRepository(new HrsEmployee());
        $this->practice = new PracticeRepository(new Practice());
        $this->stores = new ProductReposity(new ProductStore());
        $this->departments = new PracticeRepository(new Department());
        $this->product_pricing = new ProductReposity(new ProductPriceRecord());
        $this->practice_product_item = new ProductReposity(new PracticeProductItem());
        $this->product_stock_inwards = new ProductReposity(new ProductStockInward());
        $this->product_stock_out_supplies = new ProductReposity( new ProductStockSupply());
        $this->accountPaymentType = new ProductReposity( new AccountPaymentType());
        $this->practiceUser = new PracticeRepository(new PracticeUser());
        $this->goods_out_notes = new ProductReposity( new GoodsOutNote() );
    }

    public function index($practice_id =null){
        $http_resp = $this->http_response['200'];
        $transactions = array();
        if($practice_id){
            $practice = $this->practice->findByUuid($practice_id);
            $supplies = $practice->product_supply_src()->orderByDesc('created_at')->paginate(15);
            $paged_data = $this->helper->paginator($supplies);
            foreach ($supplies as $suppli) {
                array_push($transactions,$this->helper->transform_product_supply($suppli));
            }
            $paged_data['data'] = $transactions;
            $http_resp['results'] = $paged_data;
        }
        return response()->json($http_resp);
    }

    public function index_gon( $practice_id =null ){
        $http_resp = $this->http_response['200'];
        $transactions = array();
        if($practice_id){
            $practice = $this->practice->findByUuid($practice_id);
            $goods_out_notes = $practice->product_goods_out_note()->orderByDesc('created_at')->paginate(15);
            //Log::info($goods_out_notes);
            $paged_data = $this->helper->paginator($goods_out_notes);
            foreach ($goods_out_notes as $goods_out_note) {
                array_push($transactions,$this->helper->transform_gon($goods_out_note));
            }
            $paged_data['data'] = $transactions;
            $http_resp['results'] = $paged_data;
        }
        return response()->json($http_resp);
    }

    public function show($uuid){}
    public function destroy($uuid){}

    public function update(Request $request,$uuid){

        $http_resp = $this->http_response['200'];
        DB::beginTransaction();
        try{

            $rules = [
                'action' => 'required',
                'staff_id' => 'required',
            ];

            $validation = Validator::make($request->all(),$rules, $this->helper->messages());
            if ($validation->fails()){
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                return response()->json($http_resp,422);
            }

            $product_supply = $this->productSupply->findByUuid($uuid);
            $practiceUser = $this->practiceUser->findByUuid($request->staff_id);
            switch($request->action){
                case "Goods Out Note": //User requested GON Generation
                    //U
                    $goods_out_note = $product_supply->goods_out_notes()->create(['trans_number'=>'ST_']);
                    $goods_out_note->trans_number = "ST_".$goods_out_note->id."*".$product_supply->id;
                    $goods_out_note->trans_type = "Inventory Transfer";
                    $goods_out_note->note = "GON Generated from supplies";
                    $goods_out_note->save();
                    $suppy_status = $product_supply->product_supply_states()->create([
                        'status'=>Product::STATUS_PRINTED, //this means that customer had made the order, it was registered in the system and printed
                        'product_supply_id'=>$product_supply->id,
                        'note' => 'This status does not prevent item from being sold to a customer'
                    ]);
                    $suppy_status = $practiceUser->supply_status_responsible()->save($suppy_status);
                break;
            }
        }catch(\Exception $e){
            Log::info($e);
            DB::rollBack();
            $http_resp = $this->http_response['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function update_gon(Request $request,$uuid){
        $http_resp = $this->http_response['200'];
        DB::beginTransaction();
        try{

            $rules = [
                'action' => 'required',
                'staff_id' => 'required',
            ];

            $validation = Validator::make($request->all(),$rules, $this->helper->messages());
            if ($validation->fails()){
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                return response()->json($http_resp,422);
            }
            //$product_supply = $this->productSupply->findByUuid($uuid);
            $practiceUser = $this->practiceUser->findByUuid($request->staff_id);
            //Find GON by Uuid
            $goods_on = $this->goods_out_notes->findByUuid($uuid);
            //Find Transaction owning this GON e.g. ProductSupply
            $transactionab = $goods_on->transactionable()->get()->first();
            //Create the latest Transaction status
            $suppy_status = $transactionab->product_supply_states()->create([
                'status'=>$request->status,
                'product_supply_id'=>$transactionab->id,
                'note' => 'New status Update'
            ]);
            //Save user responsible for creating this status
            $suppy_status = $practiceUser->supply_status_responsible()->save($suppy_status);
            $http_resp['description'] = "Successful processed your request!";

        }catch(\Exception $e){
            Log::info($e);
            DB::rollBack();
            $http_resp = $this->http_response['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function create(Request $request){

        $http_resp = $this->http_response['200'];
        $http_resp['description'] = "Supply created successful!";
        $rule = [
            'action_taken'=>'required',
            'payment_method_id' => 'required',
            'branch_id' => 'required',
            'store_id' => 'required',
            'department_id' => 'required',
        ];
        $validation = Validator::make($request->all(),$rule, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{

            $practiceUser = $this->practiceUser->findByUuid($request->src_address['staff_id']);
            //Payment type
            $payment_type = $this->accountPaymentType->findByUuid($request->payment_method_id);
            $car_driver = $this->employees->findByUuid($request->driver_id);
            $vehicle = $this->vehicles->findByUuid($request->vehicle_id);
            //Destination Facility
            $dest_practice = $this->practice->findByUuid($request->branch_id);
            $dest_store = $this->stores->findByUuid($request->store_id);
            $dest_sub_store = $this->stores->findByUuid($request->sub_store_id);
            $dest_department = $this->departments->findByUuid($request->department_id);
            //
            $src_address = $request->src_address;
            $product_supply = $this->productSupply->create($request->all());
            $product_supply->trans_number = "SP".$product_supply->id; //set trans_number
            $product_supply->payment_type_id = $payment_type->id; //set payment type
            $product_supply->save();
            //User who created this
            //$product_supply = $practiceUser->supply_requested()->create($product_supply);
            //
            $practice = $this->practice->findByUuid($request->practice_id);
            $parentPractice = $this->practice->findParent($practice);
            $src_department = $this->departments->findByUuid($src_address['department_id']);
            $src_store = $this->stores->findByUuid($src_address['store_id']);
            $src_sub_store = $this->stores->findByUuid($src_address['sub_store_id']);
            //Save sources
            //$product_supply = $product_supply->owner()->save($parentPractice);//Enterprise level
            $product_supply = $parentPractice->product_supply()->save($product_supply);

            $product_supply = $practice->product_supply_src()->save($product_supply);//Facility from
            if( $src_department ){ $product_supply = $src_department->product_supply_src()->save($product_supply); }//Department from
            if( $src_store ){ $product_supply = $src_store->product_supply_src()->save($product_supply); }//Source store
            if( $src_sub_store ){ $product_supply = $src_sub_store->product_supply_substore_src()->save($product_supply); } //Source Sub store
            //Save transportation
            if($vehicle){ $product_supply = $vehicle->product_supply()->save($product_supply); }
            if($car_driver){ $product_supply = $car_driver->product_supply()->save($product_supply); }
            //Save Destinations
            $product_supply = $dest_practice->product_supply_dest()->save($product_supply);//Facility To
            $product_supply = $dest_department->product_supply_dest()->save($product_supply); //Department to
            if($dest_store){
                $product_supply = $dest_store->product_supply_dest()->save($product_supply);//Store To
            }
            if($dest_sub_store){
                $product_supply = $dest_sub_store->product_supply_substore_dest()->save($product_supply); //Sub store to
            }
            //Save Items
            $supply_items = $request->items;
            for ($i=0; $i < sizeof($supply_items); $i++) {

                $pract_prod_item = $this->practice_product_item->findByUuid($supply_items[$i]['id']);
                $price = $this->product_pricing->createPrice($pract_prod_item->id,
                            $practice->id,$supply_items[$i]['unit_cost'],$supply_items[$i]['unit_retail'],
                            $supply_items[$i]['pack_cost'],$supply_items[$i]['pack_retail'],$request->user()->id);

                $supply_item_input = $request->all();
                $supply_item_input['qty'] = $supply_items[$i]['qty'];
                $supply_item_input['discount_allowed'] = $supply_items[$i]['discount_allowed'];
                $supply_item_input['total_tax'] = 0;
                $supply_item_input['product_price_id'] = $price->id;
                $supply_item_input['product_item_id'] = $pract_prod_item->id;
                $supply_item_input['description'] = $supply_items[$i]['note'];
                $suppl_item = $product_supply->product_supply_items()->create($supply_item_input);
                //Check and deduct from batch numbers that were selected
                $selected_batches = $supply_items[$i]['default_batched_stock'];
                //Log::info($selected_batches);
                $rem_stock = $supply_items[$i]['qty'];
                // Log::info($rem_stock);
                // Log::info($i);
                // Log::info("---------------------");
                for ($b=0; $b < sizeof($selected_batches); $b++) {
                    $inward_stock_record = $this->product_stock_inwards->findByUuid($selected_batches[$b]['id']);
                    $ini = $request->all();
                    if( $selected_batches[$b]['stock'] >= $rem_stock ){ //Supplied stock is less than stock in first batch
                        Log::info('At index '.$i.' Batch stock '.$selected_batches[$b]['stock'].' is more than Qty '.$rem_stock);
                        $ini['batch_number'] = $selected_batches[$b]['batch_number'];
                        $ini['amount'] = $rem_stock;
                        $ini['product_supply_item_id'] = $suppl_item->id;
                        $ini['product_stock_inward_id'] = $inward_stock_record->id;
                        $product_stock_out_supply = $this->product_stock_out_supplies->create($ini);
                        //Log::info("Saved. END#");
                        break;
                    }else{
                        //Log::info('At index '.$i.' Batch stock '.$selected_batches[$b]['stock'].' is Less than Qty '.$rem_stock);
                        $ini['batch_number'] = $selected_batches[$b]['batch_number'];
                        $ini['amount'] = $rem_stock;
                        $ini['product_supply_item_id'] = $suppl_item->id;
                        $ini['product_stock_inward_id'] = $inward_stock_record->id;
                        $product_stock_out_supply = $this->product_stock_out_supplies->create($ini);
                        //Log::info('Saved all Batch stock '.$selected_batches[$b]['stock'].' BN: '.$selected_batches[$b]['batch_number']);
                        $rem_stock -= $selected_batches[$b]['stock'];
                        //Log::info('Remaining Qty to deduct from next batch is '.$rem_stock);
                    }
                }
            }

            /*
            Create a list of items and the number to be transferred. The items need to be available in
            'on hand' inventory to be transferred. Adding items onto a transfer does not allocate it
            or prevent it from being sold to a customer.
            */
            //Here the status is Pending
            $status_pack = [
                'status'=>Product::STATUS_PENDING,
                'product_supply_id'=>Product::STATUS_PENDING,
                'note' => 'This status does not prevent item from being sold to a customer',
            ];
            //
            $last_status = Product::STATUS_PENDING;
            $suppy_status = $product_supply->product_supply_states()->create($status_pack);
            //Link status to user created it: supply_status_responsible
            $suppy_status = $practiceUser->supply_status_responsible()->save($suppy_status);
            //Save Other Status
            switch($request->action_taken){
                case "Save & Print": //Save and Make it available to the store for goods to be picked
                    //Save Printed Status-----------------------------------------------------------
                    $status_pack['status'] = Product::STATUS_PRINTED;
                    $printed_status = $product_supply->product_supply_states()->create($status_pack);
                    //Link status to user created it: supply_status_responsible
                    $suppy_status = $practiceUser->supply_status_responsible()->save($printed_status);
                    $last_status = Product::STATUS_PRINTED;
                    break;
                case "Save & Pick": //Save and Pick out items(This items will not be available for sale again)
                    $last_status = Product::STATUS_PICKED;
                    //Save Printed Status-----------------------------------------------------------
                    $status_pack['status'] = Product::STATUS_PRINTED;
                    $printed_status = $product_supply->product_supply_states()->create($status_pack);
                    //Link status to user created it: supply_status_responsible
                    $suppy_status = $practiceUser->supply_status_responsible()->save($printed_status);
                    //Save Picked Status-------------------------------------------------------------
                    $status_pack['status'] = Product::STATUS_PICKED;
                    $picked_status = $product_supply->product_supply_states()->create($status_pack);
                    //Link status to user created it: supply_status_responsible
                    $suppy_status = $practiceUser->supply_status_responsible()->save($picked_status);
                    break;
                case "Save & Pack": //Save and Make it ready for shipping
                    //Save Printed Status-----------------------------------------------------------
                    $status_pack['status'] = Product::STATUS_PRINTED;
                    $printed_status = $product_supply->product_supply_states()->create($status_pack);
                    //Link status to user created it: supply_status_responsible
                    $suppy_status = $practiceUser->supply_status_responsible()->save($printed_status);
                    //Save Picked Status-------------------------------------------------------------
                    $status_pack['status'] = Product::STATUS_PICKED;
                    $picked_status = $product_supply->product_supply_states()->create($status_pack);
                    //Link status to user created it: supply_status_responsible
                    $suppy_status = $practiceUser->supply_status_responsible()->save($picked_status);
                    //Save Packed Status------------------------------------------------------------
                    $status_pack['status'] = Product::STATUS_PACKED;
                    $packed_status = $product_supply->product_supply_states()->create($status_pack);
                    //Link status to user created it: supply_status_responsible
                    $suppy_status = $practiceUser->supply_status_responsible()->save($packed_status);
                    $last_status = Product::STATUS_PACKED;
                    break;
                case "Save & Ship": //Save and Make it available to the destination warehouse(This stock should be seen under "In Transit")
                    //Save Printed Status-----------------------------------------------------------
                    $status_pack['status'] = Product::STATUS_PRINTED;
                    $printed_status = $product_supply->product_supply_states()->create($status_pack);
                    //Link status to user created it: supply_status_responsible
                    $suppy_status = $practiceUser->supply_status_responsible()->save($printed_status);
                    //Save Picked Status-------------------------------------------------------------
                    $status_pack['status'] = Product::STATUS_PICKED;
                    $picked_status = $product_supply->product_supply_states()->create($status_pack);
                    //Link status to user created it: supply_status_responsible
                    $suppy_status = $practiceUser->supply_status_responsible()->save($picked_status);
                    //Save Packed Status------------------------------------------------------------
                    $status_pack['status'] = Product::STATUS_PACKED;
                    $packed_status = $product_supply->product_supply_states()->create($status_pack);
                    //Link status to user created it: supply_status_responsible
                    $suppy_status = $practiceUser->supply_status_responsible()->save($packed_status);
                    //Save Shipped Status------------------------------------------------------------
                    $status_pack['status'] = Product::STATUS_SHIPPED;
                    $shipped_status = $product_supply->product_supply_states()->create($status_pack);
                    //Link status to user created it: supply_status_responsible
                    $suppy_status = $practiceUser->supply_status_responsible()->save($shipped_status);
                    //Supply Last Status
                    $last_status = Product::STATUS_SHIPPED;
                    break;
            }
            //Save current/Last status
            $product_supply->status = $last_status;
            $product_supply->save();
            //Generate Goods Out Note for this supply
            $gon = $product_supply->goods_out_notes()->create([
                'note'=>'GON Generated from supplies',
                'trans_type' => 'Inventory Transfer',
            ]);
            //Form Transaction Number and Update GON
            $gon->trans_number = "IT".$product_supply->id."_GN".$gon->id;
            $gon->save();
            //Link GON to Enterprise
            $gon = $parentPractice->product_goods_out_note()->save($gon);
            //Link GON to Facility
            $gon = $practice->product_goods_out_note()->save($gon);
            //
        }catch(\Exception $ex){
            $http_resp = $this->http_response['500'];
            DB::rollBack();
            Log::info($ex);
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

        
}

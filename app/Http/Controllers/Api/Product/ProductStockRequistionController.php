<?php

namespace App\Http\Controllers\Api\Product;

use App\Models\Product\Inventory\ProductRequistion;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use Nwidart\Modules\Routing\Controller;
use Illuminate\Support\Facades\Config;
use App\helpers\HelperFunctions;
use App\Models\Module\Module;
use App\Models\NotificationCenter\MailBox;
use App\Models\Product\Store\ProductStore;
use App\Models\Practice\Department;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeProductItem;
use App\Models\Practice\PracticeUser;
use App\Models\Product\Inventory\ProductStock;
use App\Models\Product\Product;
use App\Models\Product\Purchase\ProductPo;
use App\Repositories\Practice\PracticeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductStockRequistionController extends Controller
{
    protected $http_response;
    protected $helper;
    protected $productRequistion;
    protected $departments;
    protected $stores;
    protected $practice;
    protected $practiceUsers;
    protected $productItems;

    public function __construct(ProductRequistion $productRequistion)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productRequistion = new ProductReposity(new ProductRequistion());
        $this->practice = new PracticeRepository(new Practice());
        $this->departments = new PracticeRepository(new Department());
        $this->stores = new ProductReposity(new ProductStore());
        $this->practiceUsers = new PracticeRepository(new PracticeUser());
        $this->productItems = new ProductReposity(new PracticeProductItem());
    }

    public function index($practice_id=null,$department_id=null,$store_id=null,$sub_store_id=null){

        $http_resp = $this->http_response['200'];
        $results = array();
        $results_in = array();
        $results_out = array();
        $transactions = array();
        $practice = $this->practice->findByUuid($practice_id); //
        $practiceMain = $this->practice->findOwner($practice); //This returns main Facility
        $practiceParent = $this->practice->findParent($practice); //
        if($practice == $practiceMain){
            $requistions = $practiceParent->product_requisitions()->orderByDesc('created_at')->paginate(15);
        }else{
            $requistions = ProductRequistion::where('src_owning_id',$practice->id)
            ->where('src_owning_type',Practice::NAME_SPACE)
            ->orWhere('dest_owning_id',$practice->id)
            ->where('dest_owning_type',Practice::NAME_SPACE)
            ->orderByDesc('created_at')->paginate(15);
            // $requistions = DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->table('product_requistions')
            // ->paginate(15);
            //$requistions = $practice->product_requisitions()->orderByDesc('created_at')->paginate(15);
        }
        $paged_data = $this->helper->paginator($requistions);
        foreach ($requistions as $requistion) {
            array_push($transactions,$this->helper->transform_requisiton($requistion));
        }
        $paged_data['data'] = $transactions;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);

        //Log::info($practice);
        //get Requistions belonging to this facility: Outgoing requisitions

        // $external_requisitions = $practice->product_requisitions_src()->get()->sortByDesc('created_at');
        // foreach($external_requisitions as $external_requisition){
        //     array_push($results_out,$this->helper->transform_requisiton($external_requisition));
        // }
        // //Incoming
        // $external_requisitions = $practice->product_requisitions_dest()->get()->sortByDesc('created_at');
        // foreach($external_requisitions as $external_requisition){
        //     array_push($results_in,$this->helper->transform_requisiton($external_requisition,$practice));
        // }

        // $results['incomings'] = $results_in;
        // $results['outgoings'] = $results_out;
        // $http_resp['results'] = $results;
        
    }

    public function update(Request $request, $uuid){

        $http_resp = $this->http_response['200'];

        $rule1 = [
            'staff_id' => 'required',
            'action' => 'required',
            'status' => 'required'
        ];

        $validation = Validator::make($request->all(),$rule1, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{

            $requistion = $this->productRequistion->findByUuid($uuid);
            $temp_inputs = $request->all();
            switch($request->action){
                case "Deny":
                    $requistion_status = $requistion->product_requisition_movements()->create($temp_inputs);
                    $http_resp['description'] = "Declined successful!";
                    break;
                case "Status Passed":

                    //$product_supply = $this->productSupply->findByUuid($uuid);
                    $practiceUser = $this->practiceUsers->findByUuid($request->staff_id);
                    //Find GON by Uuid
                    $requistion = $this->productRequistion->findByUuid($uuid);
                    //Find Transaction owning this GON e.g. ProductSupply
                    //$transactionab = $goods_on->transactionable()->get()->first();
                    //Create the latest Transaction status
                    $suppy_status = $requistion->product_requisition_states()->create([
                        'status'=>$request->status,
                        'product_supply_id'=>$requistion->id,
                        'note' => 'New status Update'
                    ]);
                    //Save user responsible for creating this status
                    $suppy_status = $practiceUser->requisition_status_responsible()->save($suppy_status);
                    $http_resp['description'] = "Successful processed your request!";

                    // $status_pack = [
                    //     'status'=>Product::STATUS_PENDING,
                    //     'product_supply_id'=>Product::STATUS_PENDING,
                    //     'note' => 'This status does not prevent item from being sold to a customer',
                    // ];
                    // $last_status = Product::STATUS_PENDING;
                    // $suppy_status = $requistion->product_requisition_states()->create($status_pack);
                    // //Link status to user created it: requisition_status_responsible
                    // $suppy_status = $practiceUser->requisition_status_responsible()->save($suppy_status);

                    break;
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

    public function create(Request $request){

        $http_resp = $this->http_response['200'];

        $rule1 = [
            'branch_id' => 'required',
            //'request_date' => 'required',
            'due_date' => 'required',
        ];

        $validation = Validator::make($request->all(),$rule1, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();

        try{
            //Facility requesting
            $practice = $this->practice->findByUuid($request->practice_id);
            $practiceParent = $this->practice->findParent($practice);
            //get destination branch(Where items are requested from)
            $dest_branch = $this->practice->findByUuid($request->branch_id);
            $dest_store = $this->stores->findByUuid($request->store_id);
            $dest_department = $this->departments->findByUuid($request->department_id);
            $dest_sub_store = $this->stores->findByUuid($request->sub_store_id);
            //Source where requested items to be shipped
            $staff = $request->src_address;
            $practiceUser = $this->practiceUsers->findByUuid($staff['staff_id']);
            $src_department = $this->departments->findByUuid($staff['department_id']);
            $src_store = $this->stores->findByUuid($staff['store_id']);
            $src_sub_store = $this->departments->findByUuid($staff['sub_store_id']);
            $req_inputs = $request->all();
            $req_inputs['status'] = Product::STATUS_PENDING;
            //create requistion
            $requistion = $practiceParent->product_requisitions()->create($req_inputs); //Enterprise
            $requistion = $dest_store->product_requisition_dest()->save($requistion);//Store To
            $requistion->trans_number = "PR-RQ-".$requistion->id;
            $requistion = $dest_branch->product_requisitions_dest()->save($requistion); //Facility Requistion To
            $requistion = $dest_department->product_requisitions_dest()->save($requistion);//Department To
            if($dest_sub_store){
                $requistion = $dest_sub_store->product_requisition_substore_dest()->save($requistion);//Sub Store To
            }
            //source address
            $requistion = $practice->product_requisitions_src()->save($requistion); //Facility Requistion From
            $requistion = $src_department->product_requisitions_src()->save($requistion);//Department From
            $requistion = $src_store->product_requisition_src()->save($requistion); //Store from
            //$requistion = $src_sub_store->product_requisition_src()->save($requistion); //Store from
            if($src_sub_store){
                $requistion = $src_sub_store->product_requisition_substore_src()->save($requistion);//Sub Store From
            }
            //user
            $requistion = $practiceUser->product_requisitions()->save($requistion);//who requested
            //Create Status into Reqquisition Movement Status
            //--------------------------------------------------
            // $temp_inputs['status'] = "Pending";
            // $temp_inputs['note'] = "Initial status when request is placed";
            // $requistion_status = $requistion->product_requisition_movements()->create($temp_inputs);
            //--------------------------------------------------------
            //Create Requistion Items
            $items = $request->items;
            for( $i=0; $i < sizeof($items); $i++ ){
                $temp_inputs['amount'] = $items[$i]['qty'];
                $product_item = $this->productItems->findByUuid($items[$i]['id']);
                $product_price = $product_item->price_record()->where('status',true)->get()->last();
                $requistion_item = $requistion->product_requisition_items()->create($temp_inputs);//new item
                $requistion_item = $product_item->product_requisitions()->save($requistion_item);//product item
                $requistion_item = $product_price->product_requisition_items()->save($requistion_item); //prices item
            }
            
            $status_pack = [
                'status'=>Product::STATUS_PENDING,
                'product_supply_id'=>Product::STATUS_PENDING,
                'note' => 'This status does not prevent item from being sold to a customer',
            ];
            $last_status = Product::STATUS_PENDING;
            $suppy_status = $requistion->product_requisition_states()->create($status_pack);
            //Link status to user created it: requisition_status_responsible
            $suppy_status = $practiceUser->requisition_status_responsible()->save($suppy_status);
            //Save Other Status
            switch($request->action_taken){
                case "Save & Print": //Save and Make it available to the store for goods to be picked
                //Save Printed Status-----------------------------------------------------------
                $status_pack['status'] = Product::STATUS_PRINTED;
                $printed_status = $requistion->product_requisition_states()->create($status_pack);
                //Link status to user created it: requisition_status_responsible
                $suppy_status = $practiceUser->requisition_status_responsible()->save($printed_status);
                $last_status = Product::STATUS_PRINTED;
                break;
            case "Save & Pick": //Save and Pick out items(This items will not be available for sale again)
                $last_status = Product::STATUS_PICKED;
                //Save Printed Status-----------------------------------------------------------
                $status_pack['status'] = Product::STATUS_PRINTED;
                $printed_status = $requistion->product_requisition_states()->create($status_pack);
                //Link status to user created it: requisition_status_responsible
                $suppy_status = $practiceUser->requisition_status_responsible()->save($printed_status);
                //Save Picked Status-------------------------------------------------------------
                $status_pack['status'] = Product::STATUS_PICKED;
                $picked_status = $requistion->product_requisition_states()->create($status_pack);
                //Link status to user created it: requisition_status_responsible
                $suppy_status = $practiceUser->requisition_status_responsible()->save($picked_status);
                break;
            case "Save & Pack": //Save and Make it ready for shipping
                //Save Printed Status-----------------------------------------------------------
                $status_pack['status'] = Product::STATUS_PRINTED;
                $printed_status = $requistion->product_requisition_states()->create($status_pack);
                //Link status to user created it: requisition_status_responsible
                $suppy_status = $practiceUser->requisition_status_responsible()->save($printed_status);
                //Save Picked Status-------------------------------------------------------------
                $status_pack['status'] = Product::STATUS_PICKED;
                $picked_status = $requistion->product_requisition_states()->create($status_pack);
                //Link status to user created it: requisition_status_responsible
                $suppy_status = $practiceUser->requisition_status_responsible()->save($picked_status);
                //Save Packed Status------------------------------------------------------------
                $status_pack['status'] = Product::STATUS_PACKED;
                $packed_status = $requistion->product_requisition_states()->create($status_pack);
                //Link status to user created it: requisition_status_responsible
                $suppy_status = $practiceUser->requisition_status_responsible()->save($packed_status);
                $last_status = Product::STATUS_PACKED;
                break;
            case "Save & Ship": //Save and Make it available to the destination warehouse(This stock should be seen under "In Transit")
                //Save Printed Status-----------------------------------------------------------
                $status_pack['status'] = Product::STATUS_PRINTED;
                $printed_status = $requistion->product_requisition_states()->create($status_pack);
                //Link status to user created it: requisition_status_responsible
                $suppy_status = $practiceUser->requisition_status_responsible()->save($printed_status);
                //Save Picked Status-------------------------------------------------------------
                $status_pack['status'] = Product::STATUS_PICKED;
                $picked_status = $requistion->product_requisition_states()->create($status_pack);
                //Link status to user created it: requisition_status_responsible
                $suppy_status = $practiceUser->requisition_status_responsible()->save($picked_status);
                //Save Packed Status------------------------------------------------------------
                $status_pack['status'] = Product::STATUS_PACKED;
                $packed_status = $requistion->product_requisition_states()->create($status_pack);
                //Link status to user created it: requisition_status_responsible
                $suppy_status = $practiceUser->requisition_status_responsible()->save($packed_status);
                //Save Shipped Status------------------------------------------------------------
                $status_pack['status'] = Product::STATUS_SHIPPED;
                $shipped_status = $requistion->product_requisition_states()->create($status_pack);
                //Link status to user created it: requisition_status_responsible
                $suppy_status = $practiceUser->requisition_status_responsible()->save($shipped_status);
                //Supply Last Status
                $last_status = Product::STATUS_SHIPPED;
                break;
            }
            //Save current/Last status
            $requistion->status = $last_status;
            $requistion->save();
            //END
            $http_resp['description'] = "Request successful sent!";
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

<?php

namespace App\Http\Controllers\Api\Product;

use App\Models\Product\ProductReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\helpers\HelperFunctions;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Models\Product\Inventory\Inward\ProductStockInward;
use App\Models\Product\Product;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    protected $productReport;
    protected $http_response;
    protected $helper;
    protected $practice;

    public function __construct(ProductReport $productReport)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productReport = new ProductReposity($productReport);
        $this->practice = new PracticeRepository(new Practice());
    }

    public function index(){

        $http_resp = $this->http_response['200'];
        $res = array();
        $reports = ProductReport::all()->sortBy('id')->groupBy('section');
        foreach ($reports as $key => $datas) {
            $resu['section'] = $key;
            $looped_data = array();
            foreach ($datas as $data){
                $temp1['id'] = $data->id;
                $temp1['name'] = $data->name;
                $temp1['section'] = $data->section;
                $temp1['description'] = $data->description;
                array_push($looped_data,$temp1);
            }
            $resu['data'] = $looped_data;
            array_push($res,$resu);
        }
        $http_resp['results'] = $res;
        return response()->json($http_resp);
    }

    public function generate(Request $request){

        $http_resp = $this->http_response['200'];
        $rule1 = [
            'report_type' => 'required',
            'practice_id' => 'required',
        ];
        $validation = Validator::make($request->all(),$rule1, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        $results = array();
        $transactions = array();
        $total_in = 0;
        $total_out = 0;
        $practice = $this->practice->findByUuid($request->practice_id);
        switch($request->report_type){
            case "Stock Flow Statement":
                $inward = array();
                //$results['selected_dates'] = "As at ".$this->helper->format_mysql_date(date("Y-m-d H:i:s",strtotime($request->date_1)));
                //Get the Time Range specified
                //Decrement by a second from highest to lowest as you read data
                $time_range = 0;
                if($request->date_1 && $request->date_2){
                    //$seconds_range = $this->helper->calculate_date_range($request->date_1,$request->date_2)/3600;
                    $results['selected_dates'] = "From: ".$this->helper->format_mysql_date(date("Y-m-d H:i:s",strtotime($request->date_1)),'D jS M Y')." To: ".$this->helper->format_mysql_date(date("Y-m-d H:i:s",strtotime($request->date_2)),'D jS M Y');
                    $product_stocks = DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->table('product_stock_inwards')
                    ->where('owning_id',$practice->id)
                    ->where('owning_type',Practice::NAME_SPACE)
                    ->whereBetween('created_at', [$request->date_1, $request->date_2])
                    ->get();
                }else{
                    // $min_date = date("Y-m-d",strtotime($request->date_1));
                    // $max_date = date("Y-m-d",strtotime($this->helper->add_to_date($min_date,"+1 day")));
                    // $seconds_range = $this->helper->calculate_date_range($max_date,$min_date)/3600;
                    $results['selected_dates'] = "As at ".$this->helper->format_mysql_date(date("Y-m-d H:i:s",strtotime($request->date_1)));
                    $product_stocks = DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->table('product_stock_inwards')
                    ->where('owning_id',$practice->id)
                    ->where('owning_type',Practice::NAME_SPACE)
                    ->where('created_at', $request->date_1)
                    ->get();
                }
                // $product_stocks = DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->table('product_stock_inwards')
                // ->where('owning_id',$practice->id)
                // ->where('owning_type',Practice::NAME_SPACE)
                // ->whereBetween('created_at', [$request->date_1, $request->date_2])
                // ->get();
                //Log::info($product_stocks);
                foreach ($product_stocks as $product_stoc) {
                    $product_stock_inward = $practice->product_stock_inward()->find($product_stoc->id);
                    if($product_stock_inward){
                        $stock_flows['trans_date'] = $this->helper->format_mysql_date( $product_stock_inward->created_at, "d M Y");
                        $inw = $this->helper->transform_product_stock_inward($product_stock_inward);
                        $total_in += $inw['qty'];
                        $stock_flows['inwards'] = $inw; //qty
                        $stock_flows['outwards'] = [];
                        array_push($transactions,$stock_flows);
                    }
                }

                //Log::info($transactions);

                // $seconds_range = 0;
                // for ($i=1; $i <= $seconds_range; $i++) {

                //     // $dated = $this->helper->add_to_date(date("Y-m-d H:i",strtotime($min_date.' 00:00')),'+'.$i.' minutes');
                //     // $product_stock_inwards = $practice->product_stock_inward()->get();
                //     // if($product_stock_inwards->count()){
                //     //     foreach ($product_stock_inwards as $product_stock_inward) {
                //     //         $stock_flows['trans_date'] = $this->helper->format_mysql_date( $this->helper->add_to_date(date("Y-m-d H:i:s",strtotime($request->date_1)),'+'.$i.' minutes'), "d M Y");
                //     //         $stock_flows['inwards'] = $this->helper->transform_product_stock_inward($product_stock_inward);
                //     //         $stock_flows['outwards'] = [];
                //     //         array_push($transactions,$stock_flows);
                //     //     }
                //     //     break;
                //     // }

                //     //$product_stock_inward = ProductStockInward::where('created_at',$dated)->get();
                //     //$stock_flows['trans_date'] = $this->helper->format_mysql_date( $this->helper->add_to_date(date("Y-m-d H:i:s",strtotime($request->date_1)),'+'.$i.' minutes'), "d M Y");
                //     //$stock_flows['inwards'] = "";
                //     //$stock_flows['outwards'] = "";
                //     // $inwards = $this->helper->format_stock_transaction($product_stock, null);
                //     // $inwards['date_of_trans'] = $this->helper->format_mysql_date($product_stock->created_at,"date_format");
                //     // $inwards['outwards'] = [];
                //     // array_push($inward,$inwards);
                //     // array_push($transactions,$stock_flows);
                // }
                // $product_stocks = $practice->product_stocks()->get()->sortByDesc('created_at');
                // foreach( $product_stocks as $product_stock ){
                //     if($product_stock){
                //         // $stock_flows['trans_date'] = $this->helper->format_mysql_date(date("Y-m-d H:i:s",strtotime($request->date_1)),"d M Y");
                //         // $stock_flows['inwards'] = "";
                //         // $stock_flows['outwards'] = "";
                //         // $inwards = $this->helper->format_stock_transaction($product_stock, null);
                //         // $inwards['date_of_trans'] = $this->helper->format_mysql_date($product_stock->created_at,"date_format");
                //         // $inwards['outwards'] = [];
                //         // array_push($inward,$inwards);
                //         //array_push($transactions,$stock_flows);
                //     }
                // }
                $results['data'] = $transactions;
                $results['total_inward'] = $total_in;
                $results['total_outward'] = $total_out;
                $http_resp['results'] = $results;
                break;
            case "Dashboard Summary":
                //Stock Level Map view
                $stock_map_view = array();
                $coordinates = array();
                //Inventory summary
                $inventory_summary = array();
                $qty_in_hand = 0;
                $qty_to_receive = 0;
                //Inventory Transfer Summary
                $inventory_transfer_summary = [
                    'to_be_packed' => 0,
                    'to_be_shipped' => 0,
                    'to_be_delivered' => 0,
                    'to_be_invoiced' => 0,
                    'approval_pending'=>0,
                    'to_be_picked'=>0,
                ];
                //Item status summary
                $item_active_percentage = array();
                //Purchase Orders
                $purchase_ord = [
                    'total_po' => 0,
                    'total_cost' => 0,
                    'total_items' => 0,
                ];
                //Requisitions
                $requisitions = [
                    'requisition_list' => [],
                    'requisition_summary' => [],
                ];

                //$practice = $this->practice->findByUuid($request->practice_id); //Branch Where request is coming from
                $practiceMain = $this->practice->findOwner($practice);//Main Facility
                $practiceParent = $this->practice->findParent($practice); //Parent Practice
                if( $practice == $practiceMain){
                    $facilities = $practiceParent->practices()->get();
                    //===========================Most Requested Item====================================
                    //Select Distict From Requisition Items Table
                    //Then Count there occurence
                    //Then sort results in descending order
                    //The statement below sorts all the above pseudocode
                    $most_requesteds = DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->table('product_requistion_items')
                    ->selectRaw('product_item_id, COUNT(*) as total_requist')
                    ->groupBy('product_item_id')
                    ->orderBy('total_requist', 'desc')
                    ->get();
                    $index = 0;
                    foreach ($most_requesteds as $most_requested) {
                        $product_item = $practiceParent->product_items()->find($most_requested->product_item_id);
                        $item_attri = $this->helper->create_product_attribute($product_item);
                        array_push($requisitions['requisition_list'],$item_attri);
                        if($index == 6){
                            break;
                        }
                        $index += 1;
                    }
                    // $latest_requisitions = $practiceParent->product_requisitions()->orderBy('id', 'desc')->take(5)->get();
                    // foreach ($latest_requisitions as $latest_requisition) {
                    //     $req_items = $latest_requisition->product_requisition_items()->get();
                    //     $product_item = $req_items->product_items();
                    // }
                    //===========================Most Requested Item===============================

                    //==========================================Purchase Order======================================
                    $purchase_orders = DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->table('product_pos')->whereMonth('created_at',date('m'))->get();
                    $purchase_ord['total_po'] = $purchase_orders->count();
                    foreach ($purchase_orders as $purchase_order) {
                        $purchase_po = $practiceParent->purchase_orders()->find($purchase_order->id);
                        $po_items = $purchase_po->items()->get();
                        $purchase_ord['total_items'] += $po_items->count();
                        foreach ($po_items as $po_item) {
                            $price = $po_item->prices()->get()->first();
                            $purchase_ord['total_cost'] += ($po_item->qty * $price->pack_cost);
                        }
                    }
                    //==========================================Purchase Order Ends======================================

                    //==========================================Active Items Summary======================================
                    $dats = array();
                    $temp_dat['category'] = "Active";
                    $temp_dat['category_value'] = $practiceParent->product_items()->where('status',true)->count();
                    array_push($dats,$temp_dat);
                    $temp_dat['category'] = "Inactive";
                    $temp_dat['category_value'] = $practiceParent->product_items()->where('status',false)->count();
                    array_push($dats,$temp_dat);
                    $colors = ["#2ca01c","#d34336"];
                    $item_active_percentage['category'] = 'category';
                    $item_active_percentage['category_value'] = 'category_value';
                    $item_active_percentage['data'] = $dats;
                    $item_active_percentage['colors'] = $colors;
                    //==========================================Active Items Summary Ends======================================

                    //====================Product Details===================================
                    $product_details = array();
                    $product_details['low_stock_item'] = 0;
                    $product_details['stock_out_items'] = 0;
                    $product_details['item_category'] = $practiceParent->product_category()->count();
                    $product_details['items'] = $practiceParent->product_items()->count();
                    $product_details['unconfirmed_item'] = $practiceParent->product_items()->where('confirmed',0)->count();
                    //====================Product Details End===================================

                    //==========================================Inventory Summary======================================
                    //Start facility(Main) here is main facility
                    $markerOptions['url'] = "/assets/icons/dashboard/indicator_no_item.png";
                    $markerOptions['size'] = $this->helper->google_makers_size();
                    $markerOptions['scaledSize'] = $this->helper->google_makers_scaled_size();
                    //$markerOptions['labelOrigin'] = null;
                    //Set other facility on Google map: Based on there stock level
                    foreach ($facilities as $facility) {
                        $low_stock = 0;
                        $out_stock = 0;
                        $enough_stock = 0;
                        $unknown_stock = 0;
                        //Log::info($facility);
                        //Get Product Stock Inward in a facility Uniquely Identified by Product ID: This Represent Product Item in that facility
                        //Then Loop as you sum Inward amount against consumed amount
                        //And compare against Reorder Level to Identify: If Enough, Low, Or Out of Stock
                        $product_stock_in_items = $facility->product_stock_inward()->distinct('product_item_id')->get();//This Represent The product Items in a facility
                        //Log::info($product_stock_in_items->count());
                        foreach ($product_stock_in_items as $product_stock_in_item) {
                            //Get Product Item
                            $product_item = $product_stock_in_item->product_items()->get()->first();
                            //Transform Item
                            $product_item_attr = $this->helper->create_product_attribute($product_item);
                            //Sum Total Stock on This Item
                            $total_stock = $this->helper->stock_level_processor($product_stock_in_item,$product_item,null,"Stock Level"); //Total Stock
                            $qty_in_hand += $total_stock;
                            //Check if Enough, Low, or Out of Stock
                            if($total_stock < 1){ //Out of Stock Indicator
                                $out_stock += 1;
                                $product_details['stock_out_items'] += 1;
                            }elseif($total_stock > $product_item_attr['reorder_level'] ){ //Enough Stock Indicator
                                $enough_stock += 1;
                            }elseif($total_stock < $product_item_attr['reorder_level']){ //Low Stock Indicator
                                $low_stock += 1;
                                $product_details['low_stock_item'] += 1;
                            }else { //Unkown Stock Status
                                $unknown_stock += 1;
                            }
                        }
                        if($out_stock){
                            $markerOptions['url'] = "/assets/icons/dashboard/indicator_out_stock.png";
                        }elseif($enough_stock){
                            $markerOptions['url'] = "/assets/icons/dashboard/indicator_enough_stock.png";
                        }elseif($low_stock){
                            $markerOptions['url'] = "/assets/icons/dashboard/indicator_low_stock.png";
                        }else{
                            $markerOptions['url'] = "/assets/icons/dashboard/indicator_no_item.png";
                        }
                        $temp_coord['lat'] = $facility->latitude;
                        $temp_coord['lng'] = $facility->longitude;
                        $temp_coord['full_name'] = $facility->name;
                        $temp_coord['label'] = $this->helper->google_makers_label($facility->name);
                        $temp_coord['markerOptions'] = $markerOptions;
                        array_push($coordinates,$temp_coord);
                    }
                    //Populate Inventory Summary
                    $inventory_summary['qty_in_hand'] = $qty_in_hand;
                    $qty_to_receive = $this->helper->stock_level_processor(null,null,$practiceMain,"Approved Purchase Orders");
                    $inventory_summary['qty_to_receive'] = $qty_to_receive;
                    //$stock_map_view['startLocation'] = $start_facility;
                    //==========================================Inventory Summary Ends======================================

                    //==========================================Transfer Summary======================================
                    //PENDING:- Approval manager to approve and status changes to "Printed i.e Visible to Store/warehouse and ready to allocate items to it"
                    //PICKED:- Items already allocated to it and is ready for Packing
                    //Transfer Summaries: Supply to be packed i.e  this means that supply status is PENDING > Printed >;
                    $all_supplies = $practiceMain->product_supply_src()
                    ->where('status',Product::STATUS_PENDING)
                    ->orWhere('status',Product::STATUS_PRINTED)
                    ->orWhere('status',Product::STATUS_PICKED)
                    ->orWhere('status',Product::STATUS_PACKED)
                    ->orWhere('status',Product::STATUS_SHIPPED)
                    ->orWhere('status',Product::STATUS_DELIVERED)
                    ->get();
                    foreach ($all_supplies as $all_supply) {
                        switch($all_supply->status){
                            case Product::STATUS_PENDING:
                                $inventory_transfer_summary['approval_pending'] += $all_supply->product_supply_items->sum('qty');
                                break;
                            case Product::STATUS_PRINTED: //Ready for Packing
                                //the warehouse had allocated the supply item;
                                $inventory_transfer_summary['to_be_picked'] += $all_supply->product_supply_items->sum('qty');
                                break;
                            case Product::STATUS_PICKED: //Ready for Packing
                                $inventory_transfer_summary['to_be_packed'] += $all_supply->product_supply_items->sum('qty');
                                break;
                            case Product::STATUS_PACKED: //Ready for shipping
                                $inventory_transfer_summary['to_be_shipped'] += $all_supply->product_supply_items->sum('qty');
                                break;
                            case Product::STATUS_SHIPPED: //Ready for Delivered
                                $inventory_transfer_summary['to_be_delivered'] += $all_supply->product_supply_items->sum('qty');
                                break;
                            case Product::STATUS_DELIVERED: //Ready for Delivered
                                $inventory_transfer_summary['to_be_invoiced'] += $all_supply->product_supply_items->sum('qty');
                                break;
                        }
                    }
                    //==========================================Transfer Summary Ends======================================
                    //$inventory_transfer_summary = $this->helper->stock_level_processor(null,null,$practiceMain,"Inventory Transfer Summary");
                    $stock_map_view['coordinates'] = $coordinates;
                    $stock_map_view['inventory_summary'] = $inventory_summary;
                    $stock_map_view['transfer_summary'] = $inventory_transfer_summary;
                    $stock_map_view['active_percentage'] = $item_active_percentage;
                    $stock_map_view['product_details'] = $product_details;
                    $stock_map_view['po_summary'] = $purchase_ord;
                    $stock_map_view['requisitions'] = $requisitions;
                    $http_resp['results'] = $stock_map_view;
                }
                break;
            default:
                $results['data'] = $transactions;
                $http_resp['results'] = $results;
                break;
        }
        return response()->json($http_resp);
    }

}

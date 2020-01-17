<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/14/18
 * Time: 7:41 PM
 * 
 */

namespace App\helpers;

use App\Assets\Helpers\AssetsHelper;
use App\Hrs\Helpers\HrsHelper;
use App\Repositories\Product\ProductReposity;
use App\Models\Product\Product;
use App\Models\Product\ProductGeneric;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Product\ProductType;
use App\Models\Product\ProductBrand;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductUnit;
use App\Models\Product\ProductAdministrationRoute;
use App\Models\Product\ProductCurrency;
use App\Models\Product\Sales\ProductPriceRecord;
use App\Models\Practice\PracticeProductItem;
use App\Models\Product\ProductBrandSector;
use App\Models\Product\ProductSalesCharge;
use Illuminate\Support\Facades\DB;
use App\Models\Account\Vendors\AccountVendor;
use App\Models\Product\Purchase\ProductPo;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;
use App\Models\Account\Payments\AccountPaymentType;
use Barryvdh\DomPDF\Facade as PDF;
use App\Repositories\Practice\PracticeRepository;
use App\Models\Practice\Practice;
use App\Models\Product\Inventory\ProductStock;
use App\Models\Inventory\ProductStockMovement;
use App\Models\NotificationCenter\MailBox;
use App\Models\Practice\Department;
use App\Models\Product\Inventory\Inward\ProductStockInward;
use App\Models\Product\Inventory\ProductRequistion;
use App\Models\Product\ProductItem;
use App\Models\Product\Purchase\GrnNote;
use App\Models\Product\Store\ProductStore;
use App\Models\Product\Supply\GoodsOutNote;
use App\Models\Product\Supply\ProductSupply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class HelperFunctions
{
    public function get_default_filter($company=null){
        if($company){
            $date_format = $company->date_format;
            $first = date($date_format, strtotime("first day of this month"));
            $last = date($date_format, strtotime("last day of this month"));
            $today = date($date_format);
        }else{
            $first = date("Y-m-d", strtotime("first day of this month"));
            $last = date("Y-m-d", strtotime("last day of this month"));
            $today = date("Y-m-d");
        }
        return [
            'start'=>$first,
            'last'=>$last,
            'end'=>$last,
            'today'=>$today
        ];
    }

    public function format_lunox_date($date_to){
        $lunox_str = "T00:00:00.000Z";
        return str_replace($lunox_str, "", $date_to);
    }

    public function get_default_date_range(){

        $first = date("j M Y", strtotime("first day of this month"));
        $last = date("j M Y", strtotime("last day of this month"));
        return $first." to ".$last;
    }

    public function taxation_calculation( $prices=[], $taxations=[] ){

        if( sizeof($prices) && sizeof($taxations) ){

            /*
                $prices array must contain the following indexes:
                [
                    'unit_cost'
                    'unit_retail_price'
                    'pack_cost'
                    'pack_retail_price'
                ]
            */

            /*
                $taxations array must contain the following arrays:
                [
                    [
                        'name'
                        'collected_on_sales'
                        'collected_on_purchase'
                        'purchase_rate'
                        'sales_rate'
                        'amount'
                    ],
                    [
                        'name'
                        'collected_on_sales'
                        'collected_on_purchase'
                        'purchase_rate'
                        'sales_rate'
                        'amount'
                    ]
                ]
            */

            $pack_purchase_rate = $prices['pack_cost'];
            $pack_sales_rate = $prices['pack_retail_price'];
            $unit_purchase_rate = $prices['unit_cost'];
            $unit_sales_rate = $prices['unit_retail_price'];

            for ($i=0; $i < sizeof($taxations); $i++) {
                //calculate final sales rate if "collected_on_sales" is TRUE
                if( $taxations[$i]['collected_on_sales'] && $taxations[$i]['sales_rate']  ){
                    //WholeSales(pack_s_t_value: Pack Sales Tax Value)
                    $pack_s_t_value = ($taxations[$i]['sales_rate']/100) * $prices['pack_retail_price'];
                    $pack_sales_rate -= $pack_s_t_value;
                    //Retail Sales
                    $unit_s_t_value = ($taxations[$i]['sales_rate']/100) * $prices['unit_retail_price'];
                    $unit_sales_rate -= $unit_s_t_value;
                }
                //calculate final purchase rate if "collected_on_purchase" is TRUE
                if( $taxations[$i]['collected_on_purchase'] && $taxations[$i]['purchase_rate'] ){
                    //Buy Per pack
                    $pack_buy_tax_value = ($taxations[$i]['purchase_rate']/100) * $prices['pack_cost'];
                    $pack_purchase_rate -= $pack_buy_tax_value;
                    //Buy Per Unit
                    $unit_buy_tax_value = ($taxations[$i]['purchase_rate']/100) * $prices['unit_cost'];
                    $unit_purchase_rate -= $unit_buy_tax_value;
                }
            }
            $prices['pack_cost'] = \round($pack_purchase_rate,2);
            $prices['pack_retail_price'] = \round($pack_sales_rate,2);
            $prices['unit_cost'] = \round($unit_purchase_rate,2);
            $prices['unit_retail_price'] = \round($unit_sales_rate,2);
        }

        return $prices;
    }

    public function create_transaction_number($trans_type,$trans_number){
        if( \strlen($trans_number) < 3 ){
            $trans_num = $trans_type.'0000'.$trans_number;
        }else{
            $trans_num = $trans_type.''.$trans_number;
        }
        return $trans_num;
    }

    public function stock_level_processor(ProductStockInward $productStockInward =null,PracticeProductItem $practiceProductItem=null,Practice $practice=null, $result_type="Stock Level"){
        $results = null;
        switch($result_type){
            case "Approved Purchase Orders": //Sum Quanties in all PO Pending Delivery
                $product_pos = $practice->purchase_orders()
                ->where('status',Product::STATUS_SUBMITTED)
                ->orWhere('status',Product::STATUS_PARTIAL)
                ->orWhere('status',Product::STATUS_EXCESS_DELIVERED)
                ->orWhere('status',Product::STATUS_LESS_DELIVERED)
                ->orWhere('status',Product::STATUS_DELIVERED)
                ->get();
                $ordered_qty = 0;
                $delivered_qty = 0;
                foreach ($product_pos as $product_po) {
                    //Count Ordered Qty
                    $ordered_qty += $product_po->items()->sum('qty');
                    $po_grns = $product_po->grn_notes()->get();
                    //Count Delivered Qty
                    foreach ($po_grns as $po_grn) {
                        $delivered_qty += $po_grn->grn_items()->sum('amount');
                    }
                }
                //Find Pending Delivery Qty
                $results = $ordered_qty - $delivered_qty;
                break;
            default: //Get Stock Level
                $total_in = $practiceProductItem->product_stock_inward()->sum('amount');
                $total_out = $practiceProductItem->product_stock_inward()->sum('consumed_amount');
                $results = $total_in - $total_out;
                break;
        }
        return $results;
    }

    public function google_makers_size(){
        return [
            'width' => 50,
            'height' => 60,
            'f' => 'px',
            'b' => 'px'
        ];
    }

    public function google_makers_label($text_){
        return [
            'text' => $text_,
            'color' => '#d34336',
            'fontWeight' => '600',
            'fontSize' => '12px'
        ];
    }

    public function google_makers_scaled_size(){
        return [
            'width' => 50,
            'height' => 60,
            'f' => 'px',
            'b' => 'px'
        ];
    }

    public function transform_payment_type(AccountPaymentType $accountPaymentType){
        return [
            'id' => $accountPaymentType->uuid,
            'name' => $accountPaymentType->name,
            'description' => $accountPaymentType->description,
        ];
    }

    public function transform_department(Department $department){
        return [
            'id' => $department->uuid,
            'name' => $department->name,
        ];
    }

    public function transform_gon(GoodsOutNote $goodsOutNote){

        $transaction_typ = $goodsOutNote->transactionable()->get()->first();
        $transaction_type = null;
        if($goodsOutNote->trans_type == "Inventory Transfer"){
            $transaction_type = $this->transform_product_supply($transaction_typ);
        }

        return [
            'id' => $goodsOutNote->uuid,
            'trans_number' => $goodsOutNote->trans_number,
            'trans_date'=>$this->format_mysql_date($goodsOutNote->created_at),
            'transaction_type' => $transaction_type,
        ];
    }

    public function transform_product_supply(ProductSupply $productSupply){

        $hrHelper = new HrsHelper();
        $assHelper = new AssetsHelper();
        $practiceRepo = new PracticeRepository(new Practice());

        $source_facility = array();
        $destination_facility = array();
        $vehicle = array();
        $supply_driver = array();
        $supply_items = array();
        $supply_states = array();
        // $agent['name'] = "Peter";
        // $agent['role'] = "Pharmacist";
        $tax = 0;
        $disc = 0;
        $total_amount = 0;
        $paid_amount = 0;
        $amount_without_disc = 0;

        $payment_type = $productSupply->payment_types()->get()->first();

        $source_practice = $productSupply->src_owning()->get()->first(); //source facility
        $src_department = $productSupply->source_departments()->get()->first(); //source department
        $source_store = $productSupply->source_stores()->get()->first(); //source store
        $source_substore = $productSupply->source_sub_stores()->get()->first();//source substore
        $src_depart['id'] = $src_department->uuid;
        $src_depart['name'] = $src_department->name;
        $src_sto = array();
        $src_sub_sto = array();

        if($source_store){
            $src_sto['id'] = $source_store->uuid;
            $src_sto['name'] = $source_store->name;
        }
        if($source_substore){
            $src_sub_sto['id'] = $source_substore->uuid;
            $src_sub_sto['name'] = $source_substore->name;
        }
        $source_facility['facility_id'] = $source_practice->uuid;
        $source_facility['facility_name'] = $source_practice->name;
        $source_facility['address'] = $source_practice->address;
        $source_facility['department'] = $src_depart;
        $source_facility['store'] = $src_sto;
        $source_facility['sub_store'] = $src_sub_sto;
        //Destinations
        $dest_practice = $productSupply->dest_owning()->get()->first();
        $destination_facility['facility_id'] = $dest_practice->uuid;
        $destination_facility['facility_name'] = $dest_practice->name;
        $destination_facility['address'] = $dest_practice->address;
        $dest_department = $productSupply->destination_departments()->get()->first();//department
        //$dest_depart = array();
        // $dest_depart['id'] = $dest_department->uuid;
        // $dest_depart['name'] = $dest_department->name;
        $destination_facility['department'] = $this->transform_department($dest_department);
        $dest_store = $productSupply->destination_stores()->get()->first();//store
        $dest_sto = array();
        $dest_sub_sto = array();
        if($dest_store){
            $dest_sto['id'] = $dest_store->uuid;
            $dest_sto['name'] = $dest_store->name;
        }
        $destination_facility['store'] = $dest_sto;
        $dest_substore = $productSupply->destination_sub_stores()->get()->first();//substore
        if($dest_substore){
            $dest_sub_sto['id'] = $dest_substore->uuid;
            $dest_sub_sto['name'] = $dest_substore->name;
        }
        $destination_facility['sub_store'] = $dest_sub_sto;
        //Get Driver
        $driver = $productSupply->employees()->get()->first();
        if($driver){
            $supply_driver = $hrHelper->transform_employee($driver);
        }
        //Get vehicle
        $vehi = $productSupply->vehicles()->get()->first();
        if($vehi){
            $vehicle = $assHelper->transform_vehicle($vehi);
        }

        $items = $productSupply->product_supply_items()->get();
        foreach ( $items as $item ) {
            $price = $item->prices()->get()->first();
            $product_item = $item->product_items()->get()->first();
            $prod_item = $this->create_product_attribute($product_item);
            $prod_item['supply_item_id'] = $item->uuid;
            $prod_item['disc_in_perc'] = $item->discount_allowed;
            $prod_item['tax'] = $item->total_tax;
            $prod_item['qty'] = $item->qty;
            $prod_item['status'] = $item->status;
            $prod_item['note'] = $item->description;
            $prod_item['unit_cost'] = $price->unit_cost;
            $prod_item['unit_retail'] = $price->unit_retail_price;
            $prod_item['pack_cost'] = $price->pack_cost;
            $prod_item['pack_retail'] = $price->pack_retail_price;
            //Calculate discount
            $total_without_disc = $prod_item['pack_retail']*$prod_item['qty'];
            $prod_item['total_without_disc'] = $total_without_disc;
            $prod_item['amount'] = $total_without_disc;
            $amount_without_disc += $total_without_disc;
            if( $item->discount_allowed > 0 ){
                $disc_ = ($item->discount_allowed/100) * $total_without_disc;
                $prod_item['amount'] = $total_without_disc - $disc_;
                $prod_item['disc_in_kes'] = $disc_;
                $disc += $disc_;
            }
            $total_amount += $prod_item['amount'];
            array_push($supply_items,$prod_item);
        }

        //Get statuses
        $supply_statuses = $productSupply->product_supply_states()->get();
        foreach ($supply_statuses as $key => $supply_statuse) {
            $temp_status['id'] = $supply_statuse->uuid;
            $temp_status['status'] = $supply_statuse->status;
            $temp_status['note'] = $supply_statuse->note;
            $temp_status['date'] = $this->format_mysql_date($supply_statuse->created_at);
            $practice_user = $supply_statuse->responsible()->get()->first();
            $temp_status['signatory'] = $practiceRepo->transform_user($practice_user);
            array_push($supply_states,$temp_status);
        }

        //Signa

        return [
            'id'=>$productSupply->uuid,
            'trans_number'=>$productSupply->trans_number,
            'sp_date' => $this->format_mysql_date($productSupply->created_at,'jS M Y'),
            'bill_no' => $productSupply->trans_number."BL",
            'bill_date' => $this->format_mysql_date($productSupply->created_at,'jS M Y'),
            'source_facility'=>$source_facility,
            'destination_facility'=>$destination_facility,
            'driver'=>$supply_driver,
            'vehicle'=>$vehicle,
            'payment_type' => $this->transform_payment_type($payment_type),
            'discount'=>$disc,
            'total_tax'=>$tax,
            'supply_mode' => 'Whole-Sale',
            'total_without_discount'=>$amount_without_disc,
            'total_amount'=>$total_amount,
            'paid_amount'=>$paid_amount,
            'balance' => $paid_amount - $paid_amount,
            'items' => $supply_items,
            'trans_status' => $supply_states
        ];

    }

    public function transform_product_stock_inward(ProductStockInward $productStockInward){
        
        $trans_number = null;
        $sources = $productStockInward->sourceable()->get()->first();
        $product_item = $productStockInward->product_items()->get()->first();
        $product = $this->create_product_attribute($product_item);
        if($productStockInward->source_type == "Purchase Order"){
            $trans_number = $sources->trans_number;
        }
        return [
            'id' => $productStockInward->id,
            'qty' => $productStockInward->amount,
            'trans_number' => $trans_number,
            'product' => $product,
        ];

    }

    public function transform_requisiton(ProductRequistion $productRequistion, Practice $subject_practice = null){

        $hrHelper = new HrsHelper();
        $assHelper = new AssetsHelper();
        $practiceRepo = new PracticeRepository(new Practice());

        $source_facility = array();
        $destination_facility = array();
        $source_practice = $productRequistion->src_owning()->get()->first(); //source facility
        $src_department = $productRequistion->source_departments()->get()->first(); //source department
        $source_store = $productRequistion->source_stores()->get()->first(); //source store
        $source_substore = $productRequistion->source_sub_stores()->get()->first();//source substore
        $src_depart['id'] = $src_department->uuid;
        $src_depart['name'] = $src_department->name;
        $src_sto = array();
        $src_sub_sto = array();
        $amount = 0;
        if($source_store){
            $src_sto['id'] = $source_store->uuid;
            $src_sto['name'] = $source_store->name;
        }
        if($source_substore){
            $src_sub_sto['id'] = $source_substore->uuid;
            $src_sub_sto['name'] = $source_substore->name;
        }
        $source_facility['facility_id'] = $source_practice->uuid;
        $source_facility['facility_name'] = $source_practice->name;
        $source_facility['department'] = $src_depart;
        $source_facility['store'] = $src_sto;
        $source_facility['sub_store'] = $src_sub_sto;
        //Destinations
        $dest_practice = $productRequistion->dest_owning()->get()->first();
        $destination_facility['facility_id'] = $dest_practice->uuid;
        $destination_facility['facility_name'] = $dest_practice->name;
        $dest_department = $productRequistion->destination_departments()->get()->first();//department
        //$dest_depart = array();
        // $dest_depart['id'] = $dest_department->uuid;
        // $dest_depart['name'] = $dest_department->name;
        $destination_facility['department'] = $this->transform_department($dest_department);
        $dest_store = $productRequistion->destination_stores()->get()->first();//store
        $dest_sto = array();
        $dest_sub_sto = array();
        if($dest_store){
            $dest_sto['id'] = $dest_store->uuid;
            $dest_sto['name'] = $dest_store->name;
        }
        $destination_facility['store'] = $dest_sto;
        $dest_substore = $productRequistion->destination_sub_stores()->get()->first();//substore
        if($dest_substore){
            $dest_sub_sto['id'] = $dest_substore->uuid;
            $dest_sub_sto['name'] = $dest_substore->name;
        }
        $destination_facility['sub_store'] = $dest_sub_sto;

        //status change
        $movements = array();
        // $statuses = $productRequistion->product_requisition_movements()->get();
        // foreach($statuses as $status){
        //     $temp_state['id']= $status->uuid;
        //     $temp_state['status']= $status->status;
        //     $temp_state['trans_date']= $this->format_mysql_date($status->created_at,'format');
        //     array_push($movements,$temp_state);
        // }

        //Get statuses
        $trans_status = array();
        $supply_statuses = $productRequistion->product_requisition_states()->get();
        foreach ($supply_statuses as $key => $supply_statuse) {
            $temp_status['id'] = $supply_statuse->uuid;
            $temp_status['status'] = $supply_statuse->status;
            $temp_status['note'] = $supply_statuse->note;
            $temp_status['date'] = $this->format_mysql_date($supply_statuse->created_at);
            $practice_user = $supply_statuse->responsible()->get()->first();
            $temp_status['signatory'] = $practiceRepo->transform_user($practice_user);
            array_push($trans_status,$temp_status);
        }

        //Requisition Items
        $items_data = array();
        $items = $productRequistion->product_requisition_items()->get();
        foreach($items as $item){
            //price at which it was supplied
            $price = $item->prices()->get()->first();
            //Log::info($price);
            $prod_item = $item->product_items()->get()->first();
            $product_item = $this->create_product_attribute($prod_item);
            $product_item['req_item_id'] = $item->uuid;
            $product_item['qty'] = $item->amount;
            $product_item['qty_approved'] = 0;
            // if( sizeof($movements) && $movements[sizeof($movements)-1] == Product::STATUS_PENDING ){
            //     $product_item['qty_approved'] = $item->amount;
            // }elseif( sizeof($movements) && $movements[sizeof($movements)-1] == Product::STATUS_APPROVED ){
            //     $product_item['qty_approved'] = $item->amount_approved;
            // }elseif( sizeof($movements) && $movements[sizeof($movements)-1] == Product::STATUS_DECLINED ){
            //     $product_item['qty_approved'] = $item->amount;
            // }else{
            //     $product_item['qty_approved'] = $item->amount;
            // }
            $product_item['qty_approved'] = $item->amount;
            $product_item['qty_shipped'] = $item->amount_shpped;
            $product_item['qty_received'] = $item->amount_received;
            $product_item['unit_retail'] = $price->unit_retail_price;
            $product_item['unit_cost'] = $price->unit_cost;
            $product_item['pack_cost'] = $price->pack_cost;
            $product_item['pack_retail'] = $price->pack_retail_price;
            $product_item['stock'] = $this->calculate_stock_figures($prod_item,$subject_practice,null,"stock");
            array_push($items_data,$product_item);
            $amount += $item->amount * $price->pack_retail_price;
        }

        //Signatories
        $signatories = array();
        // $signatorials = $productRequistion->product_requisition_shippment()->get();
        // $requested_by = $productRequistion->requested()->get()->first();
        // $req_by = array();
        // $appr_by = array();
        // $ship_by = array();
        // $recei_by = array();
        // $req_by['id']=$requested_by->uuid;
        // $req_by['first_name']=$requested_by->first_name;
        // $req_by['other_name']=$requested_by->other_name;
        // $signatories['requested_by'] = $req_by;
        // foreach($signatorials as $signatorial){
        //     $approved_by = $signatorial->approving()->get()->first();
        //     $shipped_by = $signatorial->shipping()->get()->first();
        //     $received_by = $signatorial->receiving()->get()->first();
        //     if($approved_by){
        //         $appr_by['id']=$approved_by->uuid;
        //         $appr_by['first_name']=$approved_by->first_name;
        //         $appr_by['other_name']=$approved_by->other_name;
        //     }
        //     if($shipped_by){
        //         $ship_by['id']=$shipped_by->uuid;
        //         $ship_by['first_name']=$shipped_by->first_name;
        //         $ship_by['other_name']=$shipped_by->other_name;
        //     }
        //     if($received_by){
        //         $recei_by['id']=$received_by->uuid;
        //         $recei_by['first_name']=$received_by->first_name;
        //         $recei_by['other_name']=$received_by->other_name;
        //     }
        // }
        // $signatories['approved_by'] = $appr_by;
        // $signatories['shipped_by'] = $ship_by;
        // $signatories['received_by'] = $recei_by;

        // $approver['id'] = "1";
        // $approver['name'] = "Peter";
        // $approver['role'] = "Pharmacist";

        $overdue = false;
        if( $this->isPastDate($productRequistion->due_date) ){
            $overdue = true;
        }

        return [
            'id' => $productRequistion->uuid,
            'trans_number' => $productRequistion->trans_number,
            'due_date' => $this->format_mysql_date($productRequistion->due_date,'D jS M Y'),
            'trans_date' => $this->format_mysql_date($productRequistion->created_at,'D jS M Y'),
            'note' => $productRequistion->note,
            'source_facility' => $source_facility,
            'destination_facility' => $destination_facility,
            //'next_approver' => $approver,
            'overdue' => $overdue,
            'amount' => $amount,
            'items' => $items_data,
            'trans_status' => $trans_status
            //'signatories' => $signatories,
        ];
    }

    public function transform_goods_received_note(GrnNote $grnNote){

        $deliver = array();
        $sto = array();
        $substo = array();
        $depart = array();
        $received_by  = array();
        $checked_by  = array();
        $items = array();
        $practRepo = new PracticeRepository(new Practice());
        $transaction = $grnNote->transactionable()->get()->first(); //This can be a Purchase Order(PO)
        if($grnNote->transaction_type == MailBox::PO_SUBJECT){ //Check if it is a Purchase Order
            $grn_items = $grnNote->grn_items()->get(); //Get goods Received Note Items
            $po_items = $transaction->items()->get();//Get PO Items
            foreach ($grn_items as $grn_item) { //Loops to check po ordered qty against grn delivered qty
                $product_item = $grn_item->product_items()->get()->first();
                $product_it = $this->create_product_attribute($product_item);
                $product_it['delivered_qty'] = $grn_item->amount;
                $product_it['comment'] = $grn_item->comment;
                foreach ($po_items as $po_item) {
                    $price = $po_item->prices()->get()->first();
                    if($po_item->product_item_id == $grn_item->product_item_id ){
                        $product_it['ordered_qty'] = $po_item->qty;
                        $product_it['pack_cost'] = $price->pack_cost;
                        $product_it['pack_retail'] = $price->pack_retail_price;
                        $product_it['unit_retail'] = $price->unit_retail_price;
                        $product_it['unit_cost'] = $price->unit_cost;
                    }
                }
                array_push($items,$product_it);
            }
        }
        
        $store = $grnNote->stores()->get()->first();
        if($store){
            $sto = $this->transform_store($store);
        }
        $department = $grnNote->departments()->get()->first();
        if($department){
            $depart = $this->transform_department($department);
        }
        $substore = $grnNote->substores()->get()->first();
        if($substore){
            $substo = $this->transform_store($substore);
        }
        $delivery = $grnNote->deliverylocation()->get()->first();
        if($delivery){
            //$practRepo = new PracticeRepository(new Practice());
            $deliver = $practRepo->transform_($delivery);
        }
        //Received by
        $receiveduser = $grnNote->receivedby()->get()->first();
        if($receiveduser){
            $received_by = $practRepo->transform_user($receiveduser);
        }
        //checked by
        $checkedby = $grnNote->checkedby()->get()->first();
        if($checkedby){
            $checked_by = $practRepo->transform_user($checkedby);
        }

        return [
            'id' => $grnNote->uuid,
            'grn_number' => $grnNote->trans_number,
            'advise_note' => $grnNote->advise_note,
            'accounts_copy' => $grnNote->accounts_copy,
            'supplier_copy' => $grnNote->supplier_copy,
            'store_copy' => $grnNote->store_copy, //date_received
            'date_received' => $this->format_mysql_date($grnNote->date_received,'D jS M Y h:i A'),
            'department' => $depart,
            'store' => $sto,
            'substore' => $substo,
            'received_by' => $received_by,
            'checked_by' => $checked_by,
            'substore' => $substo,
            'delivery_location' => $deliver,
            'items' => $items
        ];
    }

    public function transform_facility(Practice $practice){
        return [
            'id'=>$practice->uuid,
            'name'=>$practice->name,
        ];
    }

    public function transform_store(ProductStore $productStore){
        $facility = $productStore->store_locatable()->get()->first();
        return [
            'id' => $productStore->uuid,
            'name' => $productStore->name,
            'min_capacity' => $productStore->min_capacity,
            'max_capacity' => $productStore->max_capacity,
            'facility_name' => $facility->name,
            'facility_id' => $facility->uuid,
            'code'=>$productStore->code,
            'type'=>$productStore->type,
            'status' =>$productStore->status,
            'facility' => $this->transform_facility($productStore->store_locatable()->get()->first()),
        ];
    }

    public function getValidationErrors($arr){
        $results = array();
        $arr = json_decode($arr);
        foreach($arr as $error2s) {
            for ($i = 0; $i < sizeof($error2s); $i++ ){
                array_push($results,$error2s[$i]);
            }
        }
        return $results;
    }

    public function format_supplier(AccountVendor $accountVendor){
        return [
            'id' => $accountVendor->id,
            'title' => 'Mr',
            'first_name' => $accountVendor->first_name,
            'other_name' => $accountVendor->other_name,
            'middle_name' => $accountVendor->middle_name,
            'email' => $accountVendor->email,
            'mobile' => $accountVendor->mobile,
            'phone' => $accountVendor->phone,
            'address' => $accountVendor->address,
            'postal_code' => $accountVendor->postal_code,
            'company' => $accountVendor->company,
            'country' => $accountVendor->country,
            'city' => $accountVendor->city,
            'fax' => $accountVendor->fax,
        ];
    }

    public function transform_stock_item(ProductStock $productStock, $format_type=null){
        $rets = $productStock->product_stock_movement()->where('movement_direction','Returns')->sum('amount');
        $moved_qty = $productStock->stock_inwards()->sum('amount');
        $product = $this->create_product_attribute($productStock->product_items()->get()->first());
        $product['purchase'] = $productStock->amount;
        $product['sold'] = 0;
        $product['barcode'] = "";
        $product['qty'] = "";
        $product['expired'] = false;
        $product['status'] = $productStock->status;
        $product['returns'] = $rets;
        $product['id'] = $productStock->uuid;
        $product['stock'] = ($productStock->amount - $moved_qty);
        return $product;
    }

    public function transform_stock_inward(ProductStockInward $productStockInward){
        $product = $this->create_product_attribute($productStockInward->product_items()->get()->first());//Product Item
        $price = $productStockInward->prices()->get()->first();//price at which it was purchased
        $inward_return = $productStockInward->inward_returns()->sum('amount');
        $product['stock'] = ($productStockInward->amount + $inward_return);
        $product['unit_cost'] = $price->unit_cost;
        $product['unit_retail'] = $price->unit_retail_price;
        $product['pack_cost'] = $price->pack_cost;
        $product['pack_retail'] = $price->pack_retail_price;
        return $product;
    }

    public function format_stock_transaction(ProductStock $productStock =null, ProductStockMovement $productStockMovement = null, $direction = "inward"){
        
        switch($direction){

            case "inward":
                $product = $this->create_product_attribute($productStock->product_items()->get()->first());
                return [
                    'id' => $productStock->uuid,
                    'amount' => $productStock->amount,
                    'origin' => "PO#1",
                    'product_item' => $product['item_name'],
                ];
                break;
        }
    }

    public function getOrigins($name_space){
        $sos = "";
        switch($name_space){
            case "App\Models\Product\Purchase\ProductPo":
            $sos = "PO";
            break;
        }
        return $sos;
    }

    public function format_purchase_order(ProductPo $productPo){

        $items = $productPo->items()->get();
        $item_array = array();
        $grn_array = array();

        $total = 0;

        $prodRepo = new ProductReposity(new Product());
        $practRepo = new PracticeRepository( new Practice());

        foreach( $items as $item ){ //product_items
            $temp_data = $this->create_product_attribute($item->product_items()->get()->first());
            $price = $item->prices()->get()->first();
            $temp_data['description'] = $item->description;
            $temp_data['qty'] = $item->qty;
            $temp_data['unit_cost'] = $price->unit_cost; //pack_cost
            $temp_data['pack_cost'] = $price->pack_cost; //pack_cost
            $temp_data['delivered_qty'] = '';
            $temp_data['comment'] = '';
            $temp_data['po_item_id'] = $item->id; //vendor_item_number
            $temp_data['vendor_item_number'] = ''; //vendor_item_number
            array_push($item_array,$temp_data);
            $total += $price->pack_cost * $item->qty;
        }

        //transform_goods_received_note
        $last_status = $productPo->statuses()->get()->last()->status;
        if($last_status == Product::STATUS_DELIVERED){
            $grn_notes_collections = $productPo->grn_notes()->get();
            foreach ($grn_notes_collections as $grn_notes_collection) {
                array_push($grn_array, $this->transform_goods_received_note($grn_notes_collection));
            }
        }

        return [
            'id' => $productPo->uuid,
            'po_number' => $productPo->trans_number,
            'total' => $total,
            'grand_total' => $total,
            'memo' => $productPo->memo,
            'message' => $productPo->message,
            'status' => $last_status,
            'po_date' => $this->format_mysql_date($productPo->po_date,'d M Y'),
            'po_due_date' => $this->format_mysql_date($productPo->po_due_date,'d M Y'),
            'purchase_type' => $productPo->purchase_type,
            'items' => $item_array,
            'supplier' => $prodRepo->getPurchaseData($productPo, 'supplier'),
            'delivery_location' => $practRepo->transform_($productPo->deliverable()->get()->first()),
            'advise_note' => '',
            'grn_notes' => $grn_array,
            'accounts_copy' => true,
            'supplier_copy' => false,
            'store_copy' => true,
            'invoice_number' => '',
        ];
    }

    public function sendOrders($mailing_address,$shipping_address,$order_data,$subject){
        switch($subject){
            case MailBox::PO_SUBJECT:
                PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                $pdf = PDF::loadView('mails.orders.purchaseorder', compact('mailing_address','shipping_address','order_data','subject'));
                Mail::send('mails.orders.po_message', compact('mailing_address','shipping_address','order_data','subject'), function($message)use($mailing_address,$pdf,$order_data) {
                    $message->to($mailing_address["email"], $mailing_address["first_name"])
                    ->subject($mailing_address["subject"])
                    ->attachData($pdf->output(), "purchase_order_".$order_data['po_number'].'.pdf');
                    });
            break;
        }
    }

    public function sendMails(Model $model = null, $subject, $message = null, $to_){

    }

    public function schedule_mail($recipient,$subject,$message){

    }

    public function encode_image($image_path = null){
        if(!$image_path){
            $image_path = "http://localhost:8000/assets/img/amref-white.png";
        }
        $image_path = "http://localhost:8000/assets/img/amref-white.png";
        $imagedata = file_get_contents($image_path);
        return $imagedata = base64_encode($imagedata);
        //$src = 'data: '.mime_content_type($image_path).';base64,'.$imagedata;
        //return $src;

    }

    public function paginator($data,$company=null){

        $filters = $this->get_default_filter();
        if($company){
            $filters = $this->get_default_filter($company);
        }
        return [
            'pagination' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem()
            ],
            'data' => [],
            'filters' => $filters,
        ];
    }

    public function product_rule(){
        //Log::info($request);
        return [
            'item_name' => 'required',
            'generic_name' => 'required',
            'manufacturer' => 'required',
            'item_code' => 'required',
            'item_type' => 'required',
            'barcode' => 'required',
            'item_note' => 'required',
            'brand_name' => 'required',
            'unit_measure' => 'required',
            'single_unit_weight' => 'required',
            'net_weight' => 'required',
            'alert_indicator_level' => 'required',
            'units_per_pack' => 'required',
            //'tax_per_unit' => 'required',
            'unit_storage_location' => 'required',
            'practice_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'balance.required' => 'Balance is required',
            'name.required' => 'Name is required',
            'items.required' => 'Items missing! List items to proceed',
            'description.required' => 'Description is required',
            'slug.required' => 'A symbol is required',
            'practice_id.required' => 'A facility is required',
            'as_at.required' => 'Starting date required!',
            'as_of.required' => 'Starting date required!',
            'account_type_id.required' => 'Account type required!',
            'account_details_id.required' => 'Account detail type required!',
            'mail_invitation.required' => 'Indicate whether to send invitation email',
            'practice_user_uuid.required' => 'Facility user is required!',
            'tax_per_unit.required' => 'Tax inclusive field is empty',
            'role_id.required' => 'User role is required',
            'branch_id.required' => 'Branch is required',
            'department_id.required' => 'Department is required!',
            'upload_type.required' => 'Indicate upload type',
            'supplier_id.required' => 'Supplier is required',
            'po_date.required' => 'Purchase Order date is required',
            'po_due_date.required' => 'Purchase Order due date is required',
            'facility_id.required' => 'Facility is required!',
            'staff_id.required' => 'Staff is required!',
            'payment_method_id.required' => 'Payment method is required!',
            'account_type_id.required' => 'Account type required!',
            'detail_type_id.required' => 'Detail type required!',
            'customer_term_id.required' => 'Payment terms required!',
            'main_account_id.required' => 'Main account is required!',
            'customer_id.required' => 'Customer is required!',
            'initial_stock.required'=> 'Initial stock on hand is required!',
            'bank_account_id.required'=>'Select a Bank or Credit Card',
            'transactions.required'=>'Bank transactions missing!',
            'bank_reconciliation_id.required'=>'Bank Reconciliation required!',
            'last_reconciliation_id.required'=>'Previous Bank Reconciliation required!',
            'bank_id.required'=>'Bank name required!',
            'bank_branch_id.required'=>'Bank Branch name is required!',
            'account_type_id.required'=>'Bank Account type required!',
            'account_number.required'=>'Bank Account number required!',
            'account_name.required'=>'Bank Account Holder required!',
            'bank_account.required'=>'Bank Account required!',
            'ledger_account_id.required'=>'Ledger account is required!',
            'payment_method.required'=>'Payment mode required!',
            'vat_pin.required'=>'VAT number is required!',
            'vat_return_id.required'=>'VAT period is required!',
            'file.max' => "Maximum file size to upload is 2MB (2000 KB). If you are uploading a photo, try to reduce its resolution to make it under 2MB"
        ];
    }

    public function msg(){
        return [
            'status'=>false,
            'message'=>'',
        ];
    }

    public function create_product_attribute(ProductItem $productItem = null,$extra_info=null){

        if( $productItem ){

            $prodRepo = new ProductReposity(new Product());
            $geneRepo = new ProductReposity(new ProductGeneric());
            $manuRepo = new ProductReposity(new Manufacturer());
            $typeRepo = new ProductReposity(new ProductType());
            $cateRepo = new ProductReposity(new ProductCategory());
            $routeRepo = new ProductReposity(new ProductAdministrationRoute());
            $brandRepo = new ProductReposity(new ProductBrand());
            $brandSectorRepo = new ProductReposity(new ProductBrandSector());
            $unitRepo = new ProductReposity(new ProductUnit());
            $priceRepo = new ProductReposity(new ProductPriceRecord());
            //$prodCurrency = new ProductReposity(new ProductCurrency());
            $productTax = new ProductReposity( new ProductSalesCharge() );
            //practice_product_item_id
            $taxes = DB::table('pract_prod_sale_charges')->where('practice_product_item_id',$productItem->id)->get();
            $taxy = array();
            foreach( $taxes as $taxe ){
                $taxValue = $productTax->find($taxe->product_sales_charge_id);
                $dat['id'] = $taxValue->id;
                $dat['tax_name'] = $taxValue->name;
                $dat['tax_value'] = $taxValue->amount;
                array_push($taxy,$dat);
            }

            $attrib = [
                'id'=>$productItem->uuid,
                'pid'=>$productItem->id,
                'item_name'=>$prodRepo->getName($productItem->product_id),
                'generic_name'=>$geneRepo->getName($productItem->generic_id),
                'sku_code'=>$productItem->item_code,
                'barcode'=>$productItem->barcode,
                'category'=>$cateRepo->getName($productItem->product_category_id),
                'manufacturer'=>$manuRepo->getName($productItem->manufacturer_id),
                'profile_name'=>$typeRepo->getName($productItem->product_type_id),
                'brand'=>$brandRepo->getName($productItem->product_brand_id),
                'brand_sector'=>$brandSectorRepo->getName($productItem->product_brand_sector_id),
                'measure_unit_name'=>$unitRepo->getName($productItem->product_unit_id),
                'measure_unit_sympol'=>$unitRepo->getName($productItem->product_unit_id, 'slug'),
                'unit_weight'=>$productItem->single_unit_weight,
                'pack_qty'=>$productItem->units_per_pack,
                'reorder_level'=>$productItem->alert_indicator_level,
                'unit_cost'=>$priceRepo->getPrices($productItem->id, 'unit_cost'),
                'unit_retail'=>$priceRepo->getPrices($productItem->id, 'unit_retail_price'),
                'pack_cost'=>$priceRepo->getPrices($productItem->id, 'pack_cost'),
                'pack_retail'=>$priceRepo->getPrices($productItem->id, 'pack_retail_price'),
                'item_taxes'=>$taxy,
                'note'=>$productItem->item_note,
                'store_location'=>$productItem->unit_storage_location,
                'qty' => 0,//from here are transactional
                'batch_number' => '',
                'exp_month' => '',
                'exp_year' => '',
                'description' => '',
                'amount' => 0,
                'discount_allowed' => 0,
                'sub_stock_total'=> 0,
                'batched_stock' => [],
                'default_batched_stock'=>[],
            ];

            switch ($extra_info){
                case "Low":
                //$inw_packs = 0;
                $inw_units = 0;
                $out_units = 0;
                $inwards = $productItem->product_stock_inward()->get();
                foreach ($inwards as $inward) {
                    $inw_units += $inward->amount * $attrib['pack_qty'];
                }
                $attrib['stock'] = $inw_units - $out_units;
                break;
            }

            return $attrib;

        }else{
            return [
                'sku_code'=>'',
                'item_name'=>'',
                'profile_name'=>'',
                'item_type'=>'',
                'unit_weight'=>'',
                'measure_unit_name'=>'',
                'measure_unit_sympol'=>'',
                'brand'=>'',
                'brand_sector'=>'',
                'manufacturer'=>'',
                'category'=>'',
                'sub_category'=>'',
                'generic_name'=>'',
                'formulation_name'=>'',
                'route_name'=>'',
                'note'=>'',
                'pack_qty'=>'',
                'prefered_supplier'=>'',
                'order_category'=>'',
                'unit_cost'=>'',
                'unit_retail'=>'',
                'pack_cost'=>'',
                'pack_retail'=>'',
                'tax_name'=>'',
                'tax_value'=>'',
                'status'=>'',
                'reorder_level'=>'',
                'store_location'=>'',
                // 'barcode'=>'',
                // 'qty' => 0,//from here are transactional
                // 'batch_number' => '',
                // 'exp_month' => '',
                // 'exp_year' => '',
                // 'description' => '',
                // 'amount' => 0,
                // 'discount_allowed' => 0,
                // 'sub_stock_total'=> 0,
                // 'batched_stock' => [],
                // 'default_batched_stock'=>[],
            ];
        }

    }

    public function calculate_stock_figures( PracticeProductItem $practiceProductItem, Practice $practice=null, Model $section=null, $figure_type ){
        $result = 0;
        switch($figure_type){
            case "stock":
                $inw_units = 0;
                $out_units = 0;
                $inwards = $practiceProductItem->product_stock_inward()->get();
                if($practice){
                    $inwards = $practiceProductItem->product_stock_inward()->where('owning_id',$practice->id)->get();
                }
                foreach ($inwards as $inward) {
                    $inw_units += $inward->amount;
                }
                $result = $inw_units;
            break;
        }
        return $result;
    }

    public function bitly_shorten($url){
        $query = array(
            "version" => "2.0.1",
            "longUrl" => $url,
            "login" => "o_60l0vlmr55", // replace with your login
            "apiKey" => "R_7b5eeaf38450422193dc62b670727fe7" // replace with your api key
        );

        $query = http_build_query($query);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api.bitly.com/v3/shorten?".$query);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);
        if( $response->status_txt == "OK") {
            return $response->data->url;
        } else {
            return null;
        }
    }

    public function calculateAge($dob){

        $age = "";
        if ($dob != ''){
            $diff = abs(time() - strtotime($dob));
            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            if ($years > 0){
                $age = $years." Year(s)";
            }elseif ($months > 0){
                $age = $months." Month(s)";
            }else{
                $age = "0 Year(s)";
            }
        }
        return $age;
    }

    public function isPastDate($given_date,$time_zone = 'Africa/Nairobi'){
        $result = false;
        date_default_timezone_set($time_zone);
        if ( strtotime($given_date) < time() ){
            $result = true;
        }
        return $result;
    }

    public function getToken($length,$prefix=null)
    {
        // TODO: Implement getToken() method.
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited
        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];
        }
        if($prefix){
            return $prefix.''.$token;
        }
        return $token;
    }

    public function getCode($x = 5){
        $min = pow(10,$x);
        $max = pow(10,$x+1)-1;
        return $value = rand($min, $max);

    }

    public function crypto_rand_secure($min, $max)
    {
        // TODO: Implement crypto_rand_secure() method.
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }

    public function getAccountNumber(){
        return mt_rand(1, 999999);
    }

    public function compare_two_dates($smaller_date, $bigger_date){
        //This function required two dates( starting with 'before date' and 'after date' )
        //It returns true if before date is smaller than after date, else it returns false
        $sm1 = date("Y-m-d", strtotime($smaller_date));
        $sm2 = date("Y-m-d", strtotime($bigger_date));
        if ( strtotime($sm2) > strtotime($sm1) ){
            return true;
        }
        return false;

    }

    public function getNextDay($duration_to_add){
        return $this->nextDay($duration_to_add);
    }

    public function getNextDate($duration_to_add, $format = "D M j Y", $time_zone = "Africa/Nairobi"){
        date_default_timezone_set($time_zone);
        //return date($format, strtotime(strftime("%Y-%m-%d", strtotime($duration_to_add))));
        return date($format, strtotime($duration_to_add));
    }

    public function get_next_week_day($duration_to_add){
        if ($duration_to_add == '0 days'){
            return date('D');
        }
        return date('D', strtotime(strftime("%Y-%m-%d", strtotime($duration_to_add))));
    }

    public function get_next_date($duration_to_add, $date=null){
        if($date){
            return date("Y-m-d", strtotime($duration_to_add, \strtotime($date)));
            //return date('Y-m-d', strtotime(strftime($date, strtotime($duration_to_add))));
        }
        return date('M j Y', strtotime(strftime("%Y-%m-%d", strtotime($duration_to_add))));
    }

    public function format_mysql_date($date_given, $date_format=null){
        // Prints the day, date, month, year, time, am or pm e.g. Tue 7th Aug 2018 10:21 am
        if(!$date_given){
            return null;
        }

        if($date_format){
            //return date("jS M Y",strtotime($date_given));
            return date($date_format,strtotime($date_given));
        }else{
            //return date("D jS M Y h:i A",strtotime($date_given));
            return date("j M Y",strtotime($date_given));
        }
    }

    public function calculate_date_range($date1,$date2){
        return  strtotime($date2) - strtotime($date1);
    }

    public function add_to_date($startdate,$range_to_add){
        return date("Y-m-d H:i",strtotime($range_to_add, strtotime($startdate)));
    }

    public function lastSeen($last_date_appeared, $time_zone = "Africa/Nairobi"){

        date_default_timezone_set($time_zone);
        $results = "";
        if ($last_date_appeared){
            // Declare and define two dates
            //$before_date = date("Y-m-d H:i:s",strtotime($last_date_appeared));
            $before_date = strtotime($last_date_appeared);
            $current_date = strtotime(date("Y-m-d H:i:s"));
            // Formulate the Difference between two dates
            $diff = abs($current_date - $before_date);
            // To get the year divide the resultant date into
            // total seconds in a year (365*60*60*24)
            $years = floor($diff / (365*60*60*24));
            // To get the month, subtract it with years and
            // divide the resultant date into
            // total seconds in a month (30*60*60*24)
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

            // To get the day, subtract it with years and
            // months and divide the resultant date into
            // total seconds in a days (60*60*24)
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

            // To get the hour, subtract it with years,
            // months & seconds and divide the resultant
            // date into total seconds in a hours (60*60)
            $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));

            // To get the minutes, subtract it with years,
            // months, seconds and hours and divide the
            // resultant date into total seconds i.e. 60
            $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);

            // To get the minutes, subtract it with years,
            // months, seconds, hours and minutes
            $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));

            if ($years > 0){
                // Prints the day, date, month, year, time, am or pm e.g. Tue 7th Aug 2018 10:21 am: D jS M Y h:i A
                $results = "offline since ".(string)date("M Y",strtotime($last_date_appeared));
                //$results = date("jS M Y",strtotime($last_date_appeared));
            }elseif($months > 0){
                $results = "offline since ".(string)date("d M",strtotime($last_date_appeared));
            }elseif ($days > 0){
                if ($days == 1){
                    $results = "yesterday ".(string)date("h:i A",strtotime($last_date_appeared));
                }elseif( ($days > 7) && ($days < 14) ){
                    $results = "left a week ago";
                }else{
                    $results = "left ".$days." days ago";
                }
            }elseif($hours > 0){
                if ($hours == 1){
                    $results = "left an hour ago";
                }else{
                    $results = "left ".$hours." hours ago";
                }

            }elseif ( $minutes > 0){
                $results = "left ".$minutes." mins ago";
            }else{
                $results = "left ".$seconds." secs ago";
            }
        }
        return $results;
    }

    public function pastDateBy($last_date_appeared, $time_zone = "Africa/Nairobi"){

        date_default_timezone_set($time_zone);
        $results = "";
        if ($last_date_appeared){
            // Declare and define two dates
            //$before_date = date("Y-m-d H:i:s",strtotime($last_date_appeared));
            $before_date = strtotime($last_date_appeared);
            $current_date = strtotime(date("Y-m-d H:i:s"));
            // Formulate the Difference between two dates
            $diff = abs($current_date - $before_date);
            // To get the year divide the resultant date into
            // total seconds in a year (365*60*60*24)
            $years = floor($diff / (365*60*60*24));
            // To get the month, subtract it with years and
            // divide the resultant date into
            // total seconds in a month (30*60*60*24)
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

            // To get the day, subtract it with years and
            // months and divide the resultant date into
            // total seconds in a days (60*60*24)
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

            // To get the hour, subtract it with years,
            // months & seconds and divide the resultant
            // date into total seconds in a hours (60*60)
            $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));

            // To get the minutes, subtract it with years,
            // months, seconds and hours and divide the
            // resultant date into total seconds i.e. 60
            $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);

            // To get the minutes, subtract it with years,
            // months, seconds, hours and minutes
            $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));

            if ($years > 0){
                // Prints the day, date, month, year, time, am or pm e.g. Tue 7th Aug 2018 10:21 am: D jS M Y h:i A
                $results = $years." year(s)";
                //$results = date("jS M Y",strtotime($last_date_appeared));
            }elseif($months > 0){
                $results = $months." month(s)";
            }elseif ($days > 0){
                if ($days == 1){
                    $results = $days." day";
                }elseif( ($days > 7) && ($days < 14) ){
                    $results = " a week ago";
                }else{
                    $results = $days." days";
                }
            }elseif($hours > 0){
                if ($hours == 1){
                    $results = "an hour ago";
                }else{
                    $results = $hours." hours";
                }

            }elseif ( $minutes > 0){
                //$results = "left ".$minutes." mins ago";
            }else{
                //$results = "left ".$seconds." secs ago";
            }
        }
        return $results;
    }

    public function postedOn($last_date_appeared, $time_zone = "Africa/Nairobi"){

        date_default_timezone_set($time_zone);
        $results = "";
        if ($last_date_appeared){
            // Declare and define two dates
            //$before_date = date("Y-m-d H:i:s",strtotime($last_date_appeared));
            $before_date = strtotime($last_date_appeared);
            $current_date = strtotime(date("Y-m-d H:i:s"));
            // Formulate the Difference between two dates
            $diff = abs($current_date - $before_date);
            // To get the year divide the resultant date into
            // total seconds in a year (365*60*60*24)
            $years = floor($diff / (365*60*60*24));
            // To get the month, subtract it with years and
            // divide the resultant date into
            // total seconds in a month (30*60*60*24)
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

            // To get the day, subtract it with years and
            // months and divide the resultant date into
            // total seconds in a days (60*60*24)
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

            // To get the hour, subtract it with years,
            // months & seconds and divide the resultant
            // date into total seconds in a hours (60*60)
            $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));

            // To get the minutes, subtract it with years,
            // months, seconds and hours and divide the
            // resultant date into total seconds i.e. 60
            $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);

            // To get the minutes, subtract it with years,
            // months, seconds, hours and minutes
            $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));

            if ($years > 0){
                // Prints the day, date, month, year, time, am or pm e.g. Tue 7th Aug 2018 10:21 am: D jS M Y h:i A
                $results = (string)date("jS M Y h:i A",strtotime($last_date_appeared));
                //$results = date("jS M Y",strtotime($last_date_appeared));
            }elseif($months > 0){
                $results = (string)date("jS M Y h:i A",strtotime($last_date_appeared));
            }elseif ($days > 0){
                if ($days == 1){
                    $results = "Yesterday ".(string)date("h:i A",strtotime($last_date_appeared));
                }elseif( ($days > 7) && ($days < 14) ){
                    $results = (string)date("jS M Y h:i A",strtotime($last_date_appeared));
                }else{
                    $results = (string)date("jS M Y h:i A",strtotime($last_date_appeared));
                }
            }elseif($hours > 0){
                if ($hours == 1){
                    $results = "Today ".(string)date("h:i A",strtotime($last_date_appeared));
                }else{
                    $results = "Today ".(string)date("h:i A",strtotime($last_date_appeared));
                }

            }elseif ( $minutes > 0){
                $results = (string)date("h:i A",strtotime($last_date_appeared));
            }else{
                $results = (string)date("h:i A",strtotime($last_date_appeared));
            }
        }
        return $results;
    }

    protected function nextDay($duration_to_add){
        return date('D M j', strtotime(strftime("%Y-%m-%d", strtotime($duration_to_add))));
    }

    public function is_file_exist($file_name){

        if ( file_exists( $file_name ) ){
            return true;
        }
        return false;
    }

    public function create_directory($directory){

        if ( file_exists( $directory ) ){
            return true;
        }
        mkdir($directory, 0777, true);
        return false;

    }

    public function create_logo_directory($company_id){
        $file_public = "/assets/company/".$company_id."/logos";
        $directory = $_SERVER['DOCUMENT_ROOT'].$file_public;
        if ( file_exists( $directory ) ){
            //return $directory;
            return [
                'file_server_root'=>$directory,
                'file_public_access'=>$file_public
            ];
        }
        mkdir($directory, 0755, true);
        return [
            'file_server_root'=>$directory,
            'file_public_access'=>$file_public
        ];
    }

    public function create_upload_directory($company_id,$document_type,$document_id){

        switch ($document_type) {
            case Product::DOC_PO:
                $file_public = "/assets/company/".$company_id."/po/".$document_id;
                break;
            case Product::DOC_BILL:
                $file_public = "/assets/company/".$company_id."/sbill/".$document_id;
                break;
            case Product::DOC_SUPPLIER_PAYMENT:
                $file_public = "/assets/company/".$company_id."/spayment/".$document_id;
                break;
            case Product::DOC_PURCHASE_RETURN:
                $file_public = "/assets/company/".$company_id."/preturn/".$document_id;
                break;
            default:
                $file_public = "/assets/company/".$company_id."/logos";
                break;
        }
        //$file_public = "/assets/company/".$company_id."/logos";
        $directory = $_SERVER['DOCUMENT_ROOT'].$file_public;
        if ( file_exists( $directory ) ){
            //return $directory;
            return [
                'file_server_root'=>$directory,
                'file_public_access'=>$file_public
            ];
        }
        mkdir($directory, 0755, true);
        return [
            'file_server_root'=>$directory,
            'file_public_access'=>$file_public
        ];
    }

    public function delete_file($file_to_delete){
        if ( file_exists( $file_to_delete ) ){
            unlink($file_to_delete);
            return true;
        }
        return false;
    }

    public function encode_mobile($mobile, $country_code = 'KE'){
        $swissNumberStr = $mobile;
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        try{
            $swissNumberProto = $phoneUtil->parse($swissNumberStr, $country_code);
            if ($phoneUtil->isValidNumber($swissNumberProto)) {
                # code...
                $phone = $phoneUtil->format($swissNumberProto, \libphonenumber\PhoneNumberFormat::E164);
                return str_replace("+","",$phone);
            }else{
                return false;
            }
        } catch (\libphonenumber\NumberParseException $e) {
            return false;
        }
    }

    public function is_website_exist($web_url){

        $file_headers = @get_headers($web_url);
        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
            return false;
        }
        else {
            return true;
        }

    }

    


}

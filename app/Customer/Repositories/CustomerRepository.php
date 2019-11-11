<?php

namespace App\Customer\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Customer\Models\CustomerTerms;
use App\Customer\Models\Customer;
use App\Customer\Models\Quote\Estimate;
use App\helpers\HelperFunctions;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeUser;
use App\Models\Product\ProductItem;
use App\Models\Product\ProductTaxation;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Support\Facades\DB;

class CustomerRepository implements CustomerRepositoryInterface{

    protected $model;
    protected $helpers;
    protected $companyUser;
    protected $productItem;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->helpers = new HelperFunctions();
        $this->companyUser = new PracticeRepository( new Practice() );
        $this->productItem = new ProductReposity( new ProductItem() );
    }

    public function all(){}
    public function find($id){}
    public function findByUuid($uuid){
        return $this->model->all()->where('uuid',$uuid)->first();
    }
    public function create($inputs = []){
        return $this->model->create($inputs);
    }

    public function transform_customer(Customer $customer){

        $customer_term = $customer->customer_terms()->get()->first();
        $term = [];
        if($customer_term){
            $term = $this->transform_term($customer_term);
        }

        $balance = 0;

        $customer_account = $customer->account_holders()->get()->first();

        if($customer_account){
            $balance = $customer_account->balance;
        }

        return [
            'id'=>$customer->uuid,
            'first_name'=>$customer->first_name,
            'other_name'=>$customer->other_name,
            'middle_name'=>$customer->middle_name,
            'title'=>$customer->title,
            'display_as'=>$customer->title." ".$customer->first_name." | ".$customer->email." | ".$customer->company,
            'company'=>$customer->company,
            'postal_code'=>$customer->postal_code,
            'country'=>$customer->country,
            'email'=>$customer->email,
            'mobile'=>$customer->mobile,
            'fax'=>$customer->fax,
            'phone'=>$customer->phone,
            'customer_term'=>$term,
            'city' => $customer->city,
            'address' => $customer->address,
            'postal_code' => $customer->postal_code,
            'prefered_payment'=>'$customer->phone',
            'business_id' => $customer->business_id,
            'status' => $customer->status,
            'balance' => $balance,
        ];

    }

    public function transform_term(CustomerTerms $customerTerms){

        return [
            'id' => $customerTerms->uuid,
            'notes' => $customerTerms->notes,
            'name' => $customerTerms->name,
        ];

    }

    public function transform_estimate(Estimate $estimate){

        //Estimate Status Changes
        $est_statuses = $estimate->estimate_status()->get();
        $trans_status = array();
        foreach ($est_statuses as $est_status) {
            $temp_status['id'] = $est_status->uuid;
            $temp_status['status'] = $est_status->status;
            $temp_status['note'] = $est_status->note;
            $temp_status['date'] = $this->helpers->format_mysql_date($est_status->created_at);
            $practice_user = $est_status->responsible()->get()->first();
            $temp_status['signatory'] = $this->companyUser->transform_user($practice_user);
            array_push($trans_status,$temp_status);
        }

        //Estimate Customer
        $custom = $estimate->customer()->get()->first();
        $customer = null;
        if($custom){
            $customer = $this->transform_customer($custom);
        }

        //Items & Totals
        $items = $estimate->items()->get();
        $est_items = array();
        $total_without_discount_and_tax = 0;
        $total_discount = 0;
        $total_taxe = 0;
        foreach( $items as $item ){
            //Get Product Item, Product Price,
            $prod_item = $item->product_items()->get()->first();
            $prod_price = $item->prices()->get()->first();
            //Each Item can be attached to multiple taxe rates
            //Get and Taxe and calculate if applied to this item
            $taxes = array(); //Array to hold all taxes applied to this Estimate Item
            $item_taxes = DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)
                ->table('estimate_item_taxations')
                ->where('estimate_item_id',$item->id)->get(); //Get all Taxes applied to this Estimate Item
            foreach($item_taxes as $item_taxe){
                //Create Eloquent Object to be passed to Taxation Tranformer
                $taxe_eloq = ProductTaxation::find($item_taxe->product_taxation_id);
                $transformed_taxe = $this->productItem->transform_taxation($taxe_eloq);
                //Replace the transformed taxes with exact values that were applied, this is because the taxe rates may have been updated after applied charged on sales transactins
                $transformed_taxe['sales_rate'] = $item_taxe->sales_rate;
                $transformed_taxe['purchase_rate'] = $item_taxe->purchase_rate;
                $transformed_taxe['collected_on_sales'] = $item_taxe->collected_on_sales;
                $transformed_taxe['collected_on_purchase'] = $item_taxe->collected_on_purchase;
                array_push($taxes,$transformed_taxe);
            }
            //Calculate Total, Sub-totals, Discount Etc
            $pricing = $this->productItem->transform_price($prod_price);
            $pricing_after_taxe = $this->helpers->taxation_calculation( $this->productItem->transform_price($prod_price), $taxes );
            $toty = $pricing['pack_retail_price'] * $item->qty;
            $total_without_discount_and_tax += $toty;
            $sub_discount = 0;
            $sub_total_tax = 0;
            if($item->discount_allowed){
                $sub_discount = (($item->discount_allowed/100) * ($item->qty * $pricing['pack_retail_price']));
            }
            $total_discount += $sub_discount;
            //Total Tax = Total Before Tax - Total After Tax
            $total_b4_tax = ($pricing['pack_retail_price'] * $item->qty);
            $total_after_tax = ($pricing_after_taxe['pack_retail_price'] * $item->qty);
            $sub_total_tax = $total_b4_tax - $total_after_tax;
            $total_taxe += $sub_total_tax;

            //Adjustments
            $adjustments = 0;

            $temp_item['id'] = $item->id;
            $temp_item['qty'] = $item->qty;
            $temp_item['product_item'] = $this->productItem->transform_product_item($prod_item);
            $temp_item['pricing'] = $pricing;
            $temp_item['pricing_after_taxe'] = $pricing_after_taxe;
            $temp_item['line_taxation'] = $taxes;
            $temp_item['line_discount'] = $sub_discount;
            $temp_item['line_total_tax'] = $sub_total_tax;
            $temp_item['line_total'] = $toty;
            $temp_item['adjustments'] = $adjustments;
            array_push($est_items,$temp_item);
        }

        return [
            'id'=>$estimate->uuid,
            'trans_number'=>$estimate->trans_number,
            'ref_number'=>$estimate->ref_number,
            'estimate_date'=>$this->helpers->format_mysql_date($estimate->estimate_date,"j M Y"),
            'expiry_date'=>$this->helpers->format_mysql_date($estimate->expiry_date,"j M Y"),
            'shipping_charges'=>$estimate->shipping_charges,
            'adjustment_charges'=>$estimate->adjustment_charges,
            'notes'=>$estimate->notes,
            'terms_condition'=>$estimate->terms_condition,
            'trans_status' => $trans_status,
            'customer' => $customer,
            'items' => $est_items,
            'total' => $total_without_discount_and_tax,
            'discount_allowed' => \round( $total_discount,2 ),
            'taxe_collected' => $total_taxe,
            'paid_amount' => 0
            //'pricing' => $pricing,
        ];

    }

}
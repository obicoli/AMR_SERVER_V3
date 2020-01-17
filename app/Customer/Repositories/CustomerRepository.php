<?php

namespace App\Customer\Repositories;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Repositories\AccountingRepository;
use Illuminate\Database\Eloquent\Model;
use App\Customer\Models\CustomerTerms;
use App\Customer\Models\Customer;
use App\Customer\Models\CustomerAddress;
use App\Customer\Models\CustomerPayment;
use App\Customer\Models\Invoice\CustomerInvoice;
use App\Customer\Models\Orders\CustomerSalesOrder;
use App\Customer\Models\Quote\Estimate;
use App\helpers\HelperFunctions;
use App\Models\Localization\Country;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeUser;
use App\Models\Product\Product;
use App\Models\Product\ProductItem;
use App\Models\Product\ProductTaxation;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerRepository implements CustomerRepositoryInterface{

    protected $model;
    protected $helpers;
    protected $companyUser;
    protected $productItem;
    protected $accounts;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->helpers = new HelperFunctions();
        $this->companyUser = new PracticeRepository( new Practice() );
        $this->productItem = new ProductReposity( new ProductItem() );
        $this->accounts = new AccountingRepository( new AccountChartAccount() );
    }

    public function all(){}
    public function find($id){}
    public function findByUuid($uuid){
        return $this->model->all()->where('uuid',$uuid)->first();
    }
    public function create($inputs = []){
        return $this->model->create($inputs);
    }

    public function transform_payment(CustomerPayment $customerPayment){

        $company = $customerPayment->owning()->get()->first();
        $date_format = $company->date_format;
        return [
            'id'=>$customerPayment->uuid,
            'trans_number'=>$customerPayment->trans_number,
            'reference_number'=>$customerPayment->reference_number,
            'amount'=>$customerPayment->amount,
            'unlocated_amount'=>0,
            'customer'=>$this->transform_customer($customerPayment->customers()->get()->first()),
            'trans_date'=>$this->helpers->format_mysql_date($customerPayment->trans_date,$date_format),
        ];

    }

    public function transform_invoices(CustomerInvoice $customerInvoice){

        $company = $customerInvoice->owning()->get()->first();
        $date_format = $company->date_format;
        $est_statuses = $customerInvoice->invoiceStatus()->get();
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
        $custom = $customerInvoice->customers()->get()->first();
        $customer = null;
        if($custom){
            $customer = $this->transform_customer($custom);
        }

        $is_overdue = null;
        if($customerInvoice->status == Product::STATUS_OPEN || $customerInvoice->status==Product::STATUS_UNPAID || $customerInvoice->status==Product::STATUS_PARTIAL_PAID){
            if($this->helpers->isPastDate($customerInvoice->due_date)){
                $is_overdue = $this->helpers->pastDateBy($customerInvoice->due_date);
                $is_overdue = "Overdue ".$is_overdue;
            }
        }

        return [
            'id'=>$customerInvoice->uuid,
            'trans_number'=>$customerInvoice->trans_number,
            'reference_number'=>$customerInvoice->reference_number,
            'document_name'=>Product::DOC_TAX_INVOICE,
            'overal_discount'=>$customerInvoice->overal_discount,
            'trans_date'=>$this->helpers->format_mysql_date($customerInvoice->trans_date,$date_format),
            'due_date'=>$this->helpers->format_mysql_date($customerInvoice->due_date,$date_format),
            'shipping_charges'=>$customerInvoice->shipping_charges,
            'adjustment_charges'=>$customerInvoice->adjustment_charges,
            'notes'=>$customerInvoice->notes,
            'terms_condition'=>$customerInvoice->terms_condition,
            'status' => $trans_status,
            'customer' => $customer,
            'is_overdue'=>$is_overdue,
            'taxation_option'=>$customerInvoice->taxation_option,
            'net_total' => $customerInvoice->net_total,
            'grand_total'=>$customerInvoice->grand_total,
            'total_discount' => \round( $customerInvoice->total_discount,2 ),
            'total_tax' => $customerInvoice->total_tax,
            'paid_amount' => 0,
            'cash_paid' => $customerInvoice->customerPayments()->sum('amount'),
            'display_as'=>$customerInvoice->trans_number.' | '.$this->helpers->format_mysql_date($customerInvoice->trans_date,$date_format),
            //'pricing' => $pricing,
        ];
    }

    public function transform_sales_order(CustomerSalesOrder $customerSalesOrder){

        //Estimate Status Changes
        $company = $customerSalesOrder->owning()->get()->first();
        $date_format = $company->date_format;
        $est_statuses = $customerSalesOrder->salesorderStatus()->get();
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
        $custom = $customerSalesOrder->customers()->get()->first();
        $customer = null;
        if($custom){
            $customer = $this->transform_customer($custom);
        }

        return [
            'id'=>$customerSalesOrder->uuid,
            'trans_number'=>$customerSalesOrder->trans_number,
            'reference_number'=>$customerSalesOrder->reference_number,
            'document_name'=>Product::DOC_SALES_ORDER,
            'trans_date'=>$this->helpers->format_mysql_date($customerSalesOrder->trans_date,$date_format),
            'due_date'=>$this->helpers->format_mysql_date($customerSalesOrder->due_date,$date_format),
            'shipping_charges'=>$customerSalesOrder->shipping_charges,
            'adjustment_charges'=>$customerSalesOrder->adjustment_charges,
            'notes'=>$customerSalesOrder->notes,
            'terms_condition'=>$customerSalesOrder->terms_condition,
            'status' => $trans_status,
            'customer' => $customer,
            'notes' => '',
            //'items' => $est_items,
            'taxation_option'=>$customerSalesOrder->taxation_option,
            'net_total' => $customerSalesOrder->net_total,
            'grand_total'=>$customerSalesOrder->grand_total,
            'total_discount' => \round( $customerSalesOrder->total_discount,2 ),
            'total_tax' => $customerSalesOrder->total_tax,
            'overal_discount' => $customerSalesOrder->overal_discount,
            'overal_discount_rate' => $customerSalesOrder->overal_discount_rate,
            'paid_amount' => 0,
            'display_as'=>$customerSalesOrder->trans_number.' | '.$this->helpers->format_mysql_date($customerSalesOrder->trans_date,$date_format),
            //'pricing' => $pricing,
        ];

    }

    public function transform_customer(Customer $customer, $detailed=null){

        $customer_term = $customer->customer_terms()->get()->first();
        $term = [];
        if($customer_term){
            $term = $this->transform_term($customer_term);
        }

        $balance = 0;
        $ledger_ac = $customer->ledger_accounts()->get()->first();
        $balance = $this->accounts->calculate_account_balance($ledger_ac);

        $addresses = [];
        $addreses = $customer->addresses()->get();
        foreach($addreses as $addrese){
            if($addrese->type == Product::BILLING_ADDRESS ){
                $addresses['billing'] = $this->transform_address($addrese);
            }
            if($addrese->type == Product::SHIPPING_ADDRESS ){
                $addresses['shipping'] = $this->transform_address($addrese);
            }
        }

        return [
            'id'=>$customer->uuid,
            'first_name'=>$customer->first_name,
            'last_name'=>$customer->last_name,
            'legal_name'=>$customer->legal_name,
            'salutation'=>$customer->salutation,
            'display_as'=>$customer->salutation.' '.$customer->first_name.' '.$customer->last_name,
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
            'business_id' => $customer->business_id,
            'status' => $customer->status,
            'balance' => $balance,
            'tax_reg_number'=>$customer->tax_reg_number,
            'credit_limit'=>$customer->credit_limit,
            'addresses'=>$addresses,
        ];

    }

    public function transform_address(CustomerAddress $customerAddress){

        if(!$customerAddress){
            return null;
        }
        $country = null;
        $countr = $customerAddress->countries()->get()->first();
        if( $countr ){
            $country = $this->transform_country( $countr );
        }
        return [
            'id'=>$customerAddress->uuid,
            'type'=>$customerAddress->type,
            'address'=>$customerAddress->address,
            'region'=>$customerAddress->region,
            'city'=>$customerAddress->city,
            'postal_code'=>$customerAddress->postal_code,
            'zip_code'=>$customerAddress->zip_code,
            'phone'=>$customerAddress->phone,
            'state'=>$customerAddress->state,
            'fax'=>$customerAddress->fax,
            'country'=>$country,
        ];
    }

    public function transform_country(Country $country){
        return [
            'id'=>$country->uuid,
            'name'=>$country->name,
            'code'=>$country->code,
            'currency'=>$country->currency,
            'currency_sympol'=>$country->currency_sympol,
            'display_as'=>$country->currency_sympol."-".$country->currency,
        ];
    }

    public function transform_term(CustomerTerms $customerTerms){
        if($customerTerms){
            return [
                'id' => $customerTerms->uuid,
                'notes' => $customerTerms->notes,
                'name' => $customerTerms->name,
            ];
        }else{
            return null;
        }
    }

    public function transform_estimate(Estimate $estimate){

        //Estimate Status Changes
        $company = $estimate->owning()->get()->first();
        $date_format = $company->date_format;
        $est_statuses = $estimate->estimate_status()
            ->where('type','status')
            ->get();
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
        $custom = $estimate->customers()->get()->first();
        $customer = null;
        if($custom){
            $customer = $this->transform_customer($custom);
        }

        return [
            'id'=>$estimate->uuid,
            'trans_number'=>$estimate->trans_number,
            'reference_number'=>$estimate->reference_number,
            'document_name'=>Product::DOC_QUOTATION,
            'trans_date'=>$this->helpers->format_mysql_date($estimate->trans_date,$date_format),
            'due_date'=>$this->helpers->format_mysql_date($estimate->due_date,$date_format),
            'shipping_charges'=>$estimate->shipping_charges,
            'adjustment_charges'=>$estimate->adjustment_charges,
            'notes'=>$estimate->notes,
            'terms_condition'=>$estimate->terms_condition,
            'status' => $trans_status,
            'customer' => $customer,
            //'items' => $est_items,
            'taxation_option'=>$estimate->taxation_option,
            'net_total' => $estimate->net_total,
            'grand_total'=>$estimate->grand_total,
            'total_discount' => \round( $estimate->total_discount,2 ),
            'total_tax' => $estimate->total_tax,
            'overal_discount_rate' => $estimate->overal_discount_rate,
            'overal_discount' => $estimate->overal_discount,
            'paid_amount' => 0,
            'display_as'=>$estimate->trans_number.' | '.$this->helpers->format_mysql_date($estimate->trans_date,$date_format),
            //'pricing' => $pricing,
        ];
    }

    public function transform_items(Model $model, $transaction=[]){

        $items = $model->items()->get();
        //Items
        //$items = $purchaseOrder->items()->get();
        
        $po_items = array();
        $total_without_discount_and_tax = 0;
        $total_discount = 0;
        $total_taxe = 0;
        foreach( $items as $item ){
            //Get Product Item, Product Price,
            $prod_item = $item->product_items()->get()->first();
            $temp_item = $this->productItem->transform_product_item($prod_item);
            $prod_price = $item->prices()->get()->first();
            //Each Item can be attached to multiple taxe rates
            //Get and Taxe and calculate if applied to this item
            $taxes = array(); //Array to hold all taxes applied to this Estimate Item
            switch ($transaction['document_name']) {
                case Product::DOC_QUOTATION:
                    $item_taxes = DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)
                    ->table('estimate_item_taxations')
                    ->where('estimate_item_id',$item->id)->get(); //Get all Taxes applied to this Estimate Item
                    break;
                    case Product::DOC_SALES_ORDER:
                    $item_taxes = DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)
                    ->table('salesorder_item_taxations')
                    ->where('sales_order_item_id',$item->id)->get(); //Get all Taxes applied to this Estimate Item
                    break;
                    case Product::DOC_TAX_INVOICE:
                        $item_taxes = DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)
                    ->table('customer_invoice_item_taxations')
                    ->where('customer_invoice_item_id',$item->id)->get();
                    break;
                default:
                    $item_taxes = DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)
                    ->table('po_item_taxations')
                    ->where('po_item_id',$item->id)->get(); //Get all Taxes applied to this Estimate Item
                    break;
            }
            
            foreach($item_taxes as $item_taxe){
                //Create Eloquent Object to be passed to Taxation Tranformer
                $taxe_eloq = ProductTaxation::find($item_taxe->product_taxation_id);
                array_push($temp_item['applied_tax_rates'],$taxe_eloq->uuid);
                $transformed_taxe = $this->productItem->transform_taxation($taxe_eloq);
                //Replace the transformed taxes with exact values that were applied, this is because the taxe rates may have been updated after applied charged on sales transactins
                $transformed_taxe['sales_rate'] = $item_taxe->sales_rate;
                $transformed_taxe['purchase_rate'] = $item_taxe->purchase_rate;
                $transformed_taxe['collected_on_sales'] = $item_taxe->collected_on_sales;
                $transformed_taxe['collected_on_purchase'] = $item_taxe->collected_on_purchase;
                array_push($taxes,$transformed_taxe);
            }

            $temp_item['taxes'] = $taxes;
            //Calculate Total, Sub-totals, Discount Etc
            $pricing = $this->productItem->transform_price($prod_price);
            $pricing_after_taxe = $this->helpers->taxation_calculation( $this->productItem->transform_price($prod_price), $taxes );
            $toty = $pricing['pack_retail_price'] * $item->qty;
            $total_without_discount_and_tax += $toty;
            //Log::info($pricing_after_taxe);
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
            
            //$temp_item['id'] = $item->uuid;
            //$temp_item = $this->productItem->transform_product_item($prod_item);
            $temp_item['po_item_id'] = $item->uuid;
            $temp_item['qty'] = $item->qty;
            $temp_item['discount_rate'] = $item->discount_rate;
            //$temp_item['product_item'] = $this->productItem->transform_product_item($prod_item);
            //$temp_item['pricing'] = $pricing;
            $temp_item['line_taxation'] = $sub_total_tax;
            $temp_item['price_after_tax'] = $pricing_after_taxe;
            //$temp_item['line_taxation'] = $taxes;
            $temp_item['line_discount'] = $sub_discount;
            $temp_item['line_total_tax'] = $sub_total_tax;
            $temp_item['line_total'] = $toty - $sub_discount;
            $temp_item['amount'] = $toty;
            $temp_item['adjustments'] = $adjustments;
            $temp_item['line_exclusive'] = $total_after_tax;
            array_push($po_items,$temp_item);
        }
        return $po_items;
    }

    public function company_terms_initialization(Model $company){
        $company->customer_terms()->create(['name'=>'net 15','notes'=>'full payment is expected within 10 days']);
        $company->customer_terms()->create(['name'=>'net 30','notes'=>'full payment is expected within 30 days']);
        $company->customer_terms()->create(['name'=>'net 45','notes'=>'full payment is expected within 45 days']);
        $company->customer_terms()->create(['name'=>'net 60','notes'=>'full payment is expected within 60 days']);
        $company->customer_terms()->create(['name'=>'2% 10, net 30','notes'=>"2% discount can be taken by the buyer only if payment is received in full within 10 days of the date of the invoice, and that full payment is expected within 30 days"]);
        $company->customer_terms()->create(['name'=>'Due on Receipt','notes'=>"You're expected to be pay as soon as possible after you receive the invoice"]);
        $company->customer_terms()->create(['name'=>'Due end of the month','notes'=>'full payment is expected end month']);
        $company->customer_terms()->create(['name'=>'Due end of next month','notes'=>'full payment is expected end of next month']);
    }

    // public function create_reports(Practice $practice, $report_type, Customer $customer=null, $filters=[] ){

    //     switch ($report_type) {
    //         case 'Top Customers by Outstanding Balance':
    //             //Get Company Default A/R
    //             $account_receivable = $practice->chart_of_accounts()->where('default_code',AccountsCoa::AC_RECEIVABLE_CODE)->get()->first();
    //             //Joins
    //             $series = array();
    //             $labels = array();
    //             $chartOptions = array();

    //             $customer_ledgers = DB::connection(Module::MYSQL_DB_CONN)->table('practices')
    //                 ->join( env('DB_ACCOUNTS_DATABASE', 'amref_accounting').'.account_chart_accounts','practices.id','=','account_chart_accounts.owning_id' )
    //                 ->join( env('DB_ACCOUNTS_DATABASE', 'amref_accounting').'.accounts_vouchers','account_chart_accounts.code','=','accounts_vouchers.debited' )
    //                 //->select([DB::RAW('DISTINCT(account_chart_accounts.code)')])
    //                 //->select(DB::raw('SUM(accounts_vouchers.amount) AS total_debited'))
    //                 ->select('account_chart_accounts.*')
    //                 ->where('practices.id',$practice->id)
    //                 ->where('account_chart_accounts.is_sub_account',true)
    //                 ->where('account_chart_accounts.accounts_type_id',$account_receivable->accounts_type_id)
    //                 ->get();

    //             // foreach( $customer_ledgers as $customer_ledger ){

    //             //     //$chart_ac_model = $this->accountings->find($customer_ledger->id);
    //             //     Log::info($customer_ledger);

    //             // }

    //                 //,DB::raw('SUM(accounts_vouchers.amount) AS total_debited')

    //             // $credited_balances = DB::connection(Module::MYSQL_DB_CONN)->table('practices')
    //             //     ->join( env('DB_ACCOUNTS_DATABASE', 'amref_accounting').'.account_chart_accounts','practices.id','=','account_chart_accounts.owning_id' )
    //             //     ->join( env('DB_ACCOUNTS_DATABASE', 'amref_accounting').'.accounts_vouchers','account_chart_accounts.code','=','accounts_vouchers.credited' )
    //             //     ->select('account_chart_accounts.*',DB::raw('SUM(accounts_vouchers.amount) AS total_credited'))
    //             //     ->where('practices.id',$practice->id)
    //             //     ->where('account_chart_accounts.is_sub_account',true)
    //             //     ->where('account_chart_accounts.accounts_type_id',$account_receivable->accounts_type_id)
    //             //     ->orderByDesc('total_credited')
    //             //     ->get();

    //                 //Log::info($customer_ledgers);
    //                 //Log::info($credited_balances->count());

    //             break;
            
    //         default:
    //             # code...
    //             break;
    //     }
    // }

}
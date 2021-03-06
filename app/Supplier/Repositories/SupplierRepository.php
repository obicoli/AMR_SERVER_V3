<?php

namespace App\Supplier\Repositories;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Repositories\AccountingRepository;
use App\Customer\Models\Customer;
use App\Customer\Repositories\CustomerRepository;
use App\Finance\Models\Banks\AccountsBank;
use App\Finance\Repositories\FinanceRepository;
use App\helpers\HelperFunctions;
use App\Models\Localization\Country;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeUser;
use App\Models\Product\Product;
use App\Models\Product\ProductItem;
use App\Models\Product\ProductTaxation;
use App\Repositories\Localization\LocalizationRepository;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use App\Supplier\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Model;
use App\Supplier\Models\Supplier;
use App\Supplier\Models\SupplierAddress;
use App\Supplier\Models\SupplierAsset;
use App\Supplier\Models\SupplierBill;
use App\Supplier\Models\SupplierCompany;
use App\Supplier\Models\SupplierCredit;
use App\Supplier\Models\SupplierPayment;
use App\Supplier\Models\SupplierReturn;
use App\Supplier\Models\SupplierTerms;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SupplierRepository implements SupplierRepositoryInterface
{

    protected $model;
    protected $helpers;
    protected $companyUser;
    protected $productItem;
    protected $customers;
    protected $accounts;
    protected $finances;
    protected $localizations;

    public function __construct( Model $model )
    {
        $this->model = $model;
        $this->helpers = new HelperFunctions();
        $this->companyUser = new PracticeRepository( new Practice() );
        $this->productItem = new ProductReposity( new ProductItem() );
        $this->customers = new CustomerRepository( new Customer() );
        $this->accounts = new AccountingRepository( new AccountChartAccount() );
        $this->finances = new FinanceRepository( new AccountsBank() );
        $this->localizations = new LocalizationRepository(new Country());
    }

    public function all(){}
    public function find($id){}
    public function findByUuid($uuid){
        return $this->model->all()->where('uuid',$uuid)->first();
    }
    public function findByTransNumber($trans_number){
        return $this->model->all()->where('trans_number',$trans_number)->first();
    }
    public function create($inputs = []){
        return $this->model->create($inputs);
    }
    public function update($inputs = [], $id){
        return $this->model->find($id)->update($inputs);
    }

    public function transform_supplier_credit(SupplierCredit $supplierCredit){

        $po_statuses = $supplierCredit->trails()->where('type','status')->get();
        $trans_status = array();
        foreach ($po_statuses as $po_status) {
            $temp_status['id'] = $po_status->uuid;
            $temp_status['status'] = $po_status->status;
            $temp_status['type'] = $po_status->type;
            $temp_status['notes'] = $po_status->notes;
            $temp_status['date'] = $this->helpers->format_mysql_date($po_status->created_at);
            $practice_user = $po_status->responsible()->get()->first();
            $temp_status['signatory'] = $this->companyUser->transform_user($practice_user);
            array_push($trans_status,$temp_status);
        }

        return [
            'id'=>$supplierCredit->uuid,
            'credit_date'=>$this->helpers->format_mysql_date($supplierCredit->credit_date),
            'trans_number'=>$supplierCredit->trans_number,
            'net_total'=>$supplierCredit->net_total,
            'applied_total'=>0,
            'status'=>$trans_status,
            'vendor'=>$this->transform_supplier($supplierCredit->suppliers()->get()->first()),
        ];
    }

    public function transform_purchase_return(SupplierReturn $supplierReturn){

        $audit_trail = array();
        $po_trails = $supplierReturn->trails()->get();
        foreach ($po_trails as $po_trail) {
            $temp_sta['id'] = $po_trail->uuid;
            $temp_sta['status'] = $po_trail->status;
            $temp_sta['type'] = $po_trail->type;
            $temp_sta['notes'] = $po_trail->notes;
            $temp_sta['date'] = date('Y-m-d H:i:s',\strtotime($po_trail->created_at));
            $practice_user = $po_trail->responsible()->get()->first();
            $temp_sta['signatory'] = $this->companyUser->transform_user($practice_user);
            array_push($audit_trail,$temp_sta);
        }

        return [
            'id'=>$supplierReturn->uuid,
            'return_date'=>$this->helpers->format_mysql_date($supplierReturn->return_date),
            'amount'=>$supplierReturn->amount,
            'document_name'=>AccountsCoa::TRANS_TYPE_PURCHASE_RETURN,
            'total_discount'=>$supplierReturn->total_discount,
            'grand_total'=>$supplierReturn->grand_total,
            'net_total'=>$supplierReturn->net_total,
            'total_tax'=>$supplierReturn->total_tax,
            'notes'=>$supplierReturn->notes,
            'taxation_option'=>$supplierReturn->taxation_option,
            'reference_number'=>$supplierReturn->reference_number,
            'trans_number'=>$supplierReturn->trans_number,
            'audit_trails'=>$audit_trail,
            'vendor' => $this->transform_supplier($supplierReturn->suppliers()->get()->first()),
        ];
    }

    public function transform_payment(SupplierPayment $supplierPayment){

        // $bill = $supplierPayment->supplierBills()->get()->first();
        // $bill_data = $this->transform_bill($bill);

        $audit_trail = array();
        $po_trails = $supplierPayment->payment_status()->get();
        foreach ($po_trails as $po_trail) {
            $temp_sta['id'] = $po_trail->uuid;
            $temp_sta['status'] = $po_trail->status;
            $temp_sta['type'] = $po_trail->type;
            $temp_sta['notes'] = $po_trail->notes;
            $temp_sta['date'] = date('Y-m-d H:i:s',\strtotime($po_trail->created_at));
            $practice_user = $po_trail->responsible()->get()->first();
            $temp_sta['signatory'] = $this->companyUser->transform_user($practice_user);
            array_push($audit_trail,$temp_sta);
        }

        $items = array();
        $bills = $supplierPayment->supplierBills()->get();
        // Log::info($pay_items);
        foreach($bills as $bill){
            //$bill = $pay_item->supplierBills()->get()->first(); //paymentItems
            //$temp_data['id'] = $pay_item->uuid;
            //$temp_data['amount'] = $pay_item->amount;
            //$temp_data['bill'] = $this->transform_bill($bill);
            $dat = $this->transform_bill($bill);
            $dat['paid_amount'] = $bill->paymentItems()->where('supplier_payment_id',$supplierPayment->id)->sum('paid_amount');
            array_push($items,$dat);
        }

        return [
            'id'=>$supplierPayment->uuid,
            'payment_date'=>$this->helpers->format_mysql_date($supplierPayment->payment_date),
            'payment_method'=>$supplierPayment->payment_method,
            'amount'=>$supplierPayment->amount,
            'settlement_type'=>$supplierPayment->settlement_type,
            'document_name'=>Product::DOC_SUPPLIER_PAYMENT,
            'notes'=>$supplierPayment->notes,
            'bills'=>$items,
            'vendor'=>$this->transform_supplier($supplierPayment->suppliers()->get()->first()),
            'reference_number'=>$supplierPayment->reference_number,
            'trans_number'=>$supplierPayment->trans_number,
            //'bill'=>$bill_data,
            'audit_trails'=>$audit_trail,
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
                case AccountsCoa::TRANS_TYPE_SUPPLIER_BILL:
                    $item_taxes = DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)
                    ->table('bill_item_taxations')
                    ->where('bill_item_id',$item->id)->get(); //Get all Taxes applied to this Estimate Item
                    break;
                case AccountsCoa::TRANS_TYPE_PURCHASE_RETURN:
                    $item_taxes = DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)
                    ->table('supplier_return_item_taxations')
                    ->where('supplier_return_item_id',$item->id)->get(); //Get all Taxes applied to this Estimate Item
                    break;
                default:
                    $item_taxes = DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)
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
            $toty = $pricing['pack_cost'] * $item->qty;
            $total_without_discount_and_tax += $toty;
            //Log::info($pricing_after_taxe);
            $sub_discount = 0;
            $sub_total_tax = 0;
            if($item->discount_allowed){
                $sub_discount = (($item->discount_allowed/100) * ($item->qty * $pricing['pack_cost']));
            }
            $total_discount += $sub_discount;
            //Total Tax = Total Before Tax - Total After Tax
            $total_b4_tax = ($pricing['pack_cost'] * $item->qty);
            $total_after_tax = ($pricing_after_taxe['pack_cost'] * $item->qty);
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

    public function transform_assets(SupplierAsset $supplierAsset){
        if($supplierAsset){
            return [
                'id'=>$supplierAsset->uuid,
                'file_path'=>$supplierAsset->file_path,
                'file_mime'=>$supplierAsset->file_mime,
                'file_name'=>$supplierAsset->file_name,
                'file_size'=>$supplierAsset->file_size,
            ];
        }else{
            return [];
        }
    }

    public function transform_supplier(Supplier $supplier, $detailed=false){
        
        //This supplier has accounting account number that keep track of all payments made to him/her 
        $account_holder = $supplier->account_holders()->get()->first();
        if($account_holder){
            $account = [
                'id'=>$account_holder->uuid,
                'account_type'=>$account_holder->account_type,
                'account_number'=>$account_holder->account_number,
                'name'=>$account_holder->name,
                'main'=>$account_holder->main,
                'bonus'=>$account_holder->bonus,
                'balance'=>$account_holder->balance,
            ];
        }else{
            $account = [];
        }
        

        //This are Billing or Shipping address specified during account creation
        $addresses = [];
        $addreses = $supplier->addresses()->get();
        foreach($addreses as $addrese){
            if($addrese->type == Product::BILLING_ADDRESS ){
                $addresses['billing'] = $this->transform_address($addrese);
            }
            if($addrese->type == Product::SHIPPING_ADDRESS ){
                $addresses['shipping'] = $this->transform_address($addrese);
            }
        }

        //Vendor Company
        //$company = $this->transform_company($supplier->supplier_companies()->get()->first());
        //This is the currency specified during account creation
        $currenc = $supplier->currencies()->get()->first();
        $currency = null;
        if($currenc){
            $currency = $this->localizations->transform_country($currenc);//$this->transform_country($currenc);
        }
        // $currency = [
        //     'id'=>$currenc->uuid,
        //     'currency_sympol'=>$currenc->currency_sympol,
        //     'currency'=>$currenc->currency,
        // ];

        $ledger_ac = $supplier->ledger_accounts()->get()->first();
        $balance = $this->accounts->calculate_account_balance($ledger_ac);

        //Banking
        $supplier_bank = $supplier->bank_accounts()->get()->first();
        $bank_account = null;
        if($supplier_bank){
            $bank_account = $this->finances->transform_bank_accounts($supplier_bank);
        }

        $payment_terms = null;
        $term = $supplier->supplier_terms()->get()->first();
        if($term){
            $payment_terms = $this->transform_term($term);
        }

        $vat = null;
        $default_vat = $supplier->vats()->get()->first();
        if($default_vat){
            $vat = $this->productItem->transform_taxation($default_vat);
        }

        if(!$detailed){

            $supplier_data = [
                'id'=>$supplier->uuid,
                'display_as'=>$supplier->salutation." ".$supplier->first_name." ".$supplier->last_name,
                'salutation'=>$supplier->salutation,
                'first_name'=>$supplier->first_name,
                'last_name'=>$supplier->last_name,
                'legal_name'=>$supplier->legal_name,
                'website'=>$supplier->website,
                'tax_reg_number'=>$supplier->tax_reg_number,
                'credit_limit'=>$supplier->credit_limit,
                'notes'=>$supplier->notes,
                'default_discount'=>$supplier->default_discount,
                'old_invoice_payment_auto_locate'=>$supplier->old_invoice_payment_auto_locate,
                'fax'=>$supplier->fax,
                'status'=>$supplier->status,
                'email'=>$supplier->email,
                'phone'=>$supplier->phone,
                'mobile'=>$supplier->mobile,
                'category'=>$supplier->category,
                'account'=>$account,
                'currency'=>$currency,
                'balance'=>$balance,
                'addresses'=>$addresses,
                'bank_account'=>$bank_account,
                'payment_term'=>$payment_terms,
                'vat'=>$vat,
            ];

        }else{


            //Get Vendor Terms
            $supplier_term = $supplier->supplier_terms()->get()->first();
            $term = [];
            if($supplier_term){
                $term = $this->transform_term($supplier_term);
            }

            $supplier_data = [
                'id'=>$supplier->uuid,
                'display_as'=>$supplier->salutation." ".$supplier->first_name." ".$supplier->last_name,
                'salutation'=>$supplier->salutation,
                'first_name'=>$supplier->first_name,
                'last_name'=>$supplier->last_name,
                'legal_name'=>$supplier->legal_name,
                'notes'=>$supplier->notes,
                //'company'=>$company,
                'status'=>$supplier->status,
                'email'=>$supplier->email,
                'phone'=>$supplier->phone,
                'mobile'=>$supplier->mobile,
                'account'=>$account,
                'currency'=>$currency,
                'balance'=>$balance,
                'addresses'=>$addresses,
                'payment_term'=>$payment_terms,
                'bank_account'=>$bank_account
            ];

        }
        
        return $supplier_data;

    }

    public function transform_address(SupplierAddress $supplierAddress){

        if(!$supplierAddress){
            return null;
        }

        $country = null;
        $countr = $supplierAddress->countries()->get()->first();
        if( $countr ){
            $country = $this->transform_country( $countr );
        }
        return [
            'id'=>$supplierAddress->uuid,
            'type'=>$supplierAddress->type,
            'address'=>$supplierAddress->address,
            'region'=>$supplierAddress->region,
            'city'=>$supplierAddress->city,
            'postal_code'=>$supplierAddress->postal_code,
            'zip_code'=>$supplierAddress->zip_code,
            'phone'=>$supplierAddress->phone,
            'state'=>$supplierAddress->state,
            'fax'=>$supplierAddress->fax,
            'country'=>$country,
        ];

    }

    public function transform_company(SupplierCompany $supplierCompany){

        return [
            'id'=>$supplierCompany->uuid,
            'name'=>$supplierCompany->name,
            'email'=>$supplierCompany->email,
            'address'=>$supplierCompany->address,
            'phone'=>$supplierCompany->phone,
            'mobile'=>$supplierCompany->mobile,
            'logo'=>$supplierCompany->logo,
            'notes'=>$supplierCompany->notes,
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

    public function transform_term(SupplierTerms $supplierTerms){

        return [
            'id' => $supplierTerms->uuid,
            'notes' => $supplierTerms->notes,
            'name' => $supplierTerms->name,
        ];

    }

    public function transform_purchase_order(PurchaseOrder $purchaseOrder){

        $po_statuses = $purchaseOrder->po_status()->where('type','status')->get();
        $trans_status = array();
        foreach ($po_statuses as $po_status) {
            $temp_status['id'] = $po_status->uuid;
            $temp_status['status'] = $po_status->status;
            $temp_status['type'] = $po_status->type;
            $temp_status['notes'] = $po_status->notes;
            $temp_status['date'] = $this->helpers->format_mysql_date($po_status->created_at);
            $practice_user = $po_status->responsible()->get()->first();
            $temp_status['signatory'] = $this->companyUser->transform_user($practice_user);
            array_push($trans_status,$temp_status);
        }

        $po_trails = $purchaseOrder->po_status()->get();
        $po_audit_trails = array();
        foreach ($po_trails as $po_trail) {
            $temp_sta['id'] = $po_trail->uuid;
            $temp_sta['status'] = $po_trail->status;
            $temp_sta['type'] = $po_trail->type;
            $temp_sta['notes'] = $po_trail->notes;
            $temp_sta['date'] = date('Y-m-d H:i:s',\strtotime($po_trail->created_at));
            $practice_user = $po_trail->responsible()->get()->first();
            $temp_sta['signatory'] = $this->companyUser->transform_user($practice_user);
            array_push($po_audit_trails,$temp_sta);
        }

        //Find Attachments
        $attachments = [];
        $attachmens = $purchaseOrder->assets()->get();
        foreach($attachmens as $attachmen){
            array_push($attachments,$this->transform_assets($attachmen));
        }

        $shipping = null;
        $shippable = $purchaseOrder->shipable()->get()->first();
        if($purchaseOrder->ship_to == Product::SHIP_TO_ORGANIZATION){
            $shipping = $this->companyUser->transform_($shippable);
        }else{
            $shipping = $this->customers->transform_customer($shippable);
        }

        //Items
        $items = $purchaseOrder->items()->get();
        $po_items = array();
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
            $item_taxes = DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)
                ->table('po_item_taxations')
                ->where('po_item_id',$item->id)->get(); //Get all Taxes applied to this Estimate Item
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
            $toty = $pricing['pack_cost'] * $item->qty;
            $total_without_discount_and_tax += $toty;
            $sub_discount = 0;
            $sub_total_tax = 0;
            if($item->discount_allowed){
                $sub_discount = (($item->discount_allowed/100) * ($item->qty * $pricing['pack_cost']));
            }
            $total_discount += $sub_discount;
            //Total Tax = Total Before Tax - Total After Tax
            $total_b4_tax = ($pricing['pack_cost'] * $item->qty);
            $total_after_tax = ($pricing_after_taxe['pack_cost'] * $item->qty);
            $sub_total_tax = $total_b4_tax - $total_after_tax;
            $total_taxe += $sub_total_tax;
            //Adjustments
            $adjustments = 0;
            
            //$temp_item['id'] = $item->uuid;
            $temp_item = $this->productItem->transform_product_item($prod_item);
            $temp_item['po_item_id'] = $item->uuid;
            $temp_item['qty'] = $item->qty;
            //$temp_item['product_item'] = $this->productItem->transform_product_item($prod_item);
            //$temp_item['pricing'] = $pricing;
            $temp_item['price_after_tax'] = $pricing_after_taxe;
            $temp_item['line_taxation'] = $taxes;
            $temp_item['line_discount'] = $sub_discount;
            $temp_item['line_total_tax'] = $sub_total_tax;
            $temp_item['line_total'] = 0;
            $temp_item['amount'] = $toty;
            $temp_item['adjustments'] = $adjustments;
            array_push($po_items,$temp_item);
        }

        return [
            'id' => $purchaseOrder->uuid,
            'notes' => $purchaseOrder->notes,
            'po_date' => date('Y-m-d',\strtotime($purchaseOrder->po_date)),//$this->helpers->format_mysql_date($purchaseOrder->po_date,"j M Y"),
            'trans_number' => $purchaseOrder->trans_number,
            'ref_number' => $purchaseOrder->ref_number,
            'vendor' => $this->transform_supplier( $purchaseOrder->suppliers()->get()->first(),true ),
            'total_grand' => 0,
            'po_due_date' => date('Y-m-d',\strtotime($purchaseOrder->po_due_date)),//$this->helpers->format_mysql_date(,"j M Y"),
            'status' => $trans_status,
            'document_name' => Product::DOC_PO,
            'bills' => null,
            'ship_to' => $purchaseOrder->ship_to,
            'shipping' => $shipping,
            'items' => $po_items,
            'other_total' => 0,
            'attachments' => $attachments,
            'audit_trails' => $po_audit_trails,
            'shipping_total' => 0,
            'taxation_option' => $purchaseOrder->taxation_option,
            'total_grand' => $total_without_discount_and_tax,
            'discount_allowed' => \round( $total_discount,2 ),
            'total_tax' => $total_taxe,
            'total_bill' => \round($total_without_discount_and_tax - $total_discount,2),
        ];
    }

    public function transform_bill(SupplierBill $supplierBill){

        $po_statuses = $supplierBill->bill_status()->where('type','status')->get();
        $trans_status = array();
        foreach ($po_statuses as $po_status) {
            $temp_status['id'] = $po_status->uuid;
            $temp_status['status'] = $po_status->status;
            $temp_status['type'] = $po_status->type;
            $temp_status['notes'] = $po_status->notes;
            $temp_status['date'] = $this->helpers->format_mysql_date($po_status->created_at);
            $practice_user = $po_status->responsible()->get()->first();
            $temp_status['signatory'] = $this->companyUser->transform_user($practice_user);
            array_push($trans_status,$temp_status);
        }
        
        $cash_paid = $supplierBill->paymentItems()->sum('paid_amount');
        $is_overdue = false;
        if($supplierBill->status == Product::STATUS_OPEN || $supplierBill->status==Product::STATUS_PARTIAL_PAID){
            if($this->helpers->isPastDate($supplierBill->due_date)){
                $is_overdue = true;
            }
        }

        return [
            'id' => $supplierBill->uuid,
            'notes' => $supplierBill->notes,
            'document_name' => AccountsCoa::TRANS_TYPE_SUPPLIER_BILL,
            'net_total' => $supplierBill->net_total,
            'grand_total' => $supplierBill->grand_total,
            'total_tax' => $supplierBill->total_tax,
            'cash_paid' => $cash_paid,
            'display_as'=>$supplierBill->trans_number.' | '.$this->helpers->format_mysql_date($supplierBill->trans_date,"j M Y").' | '.number_format($supplierBill->net_total,2),
            'is_overdue'=>$is_overdue,
            'total_discount' => $supplierBill->total_discount,
            'taxation_option' => $supplierBill->taxation_option,
            'trans_date' => $this->helpers->format_mysql_date($supplierBill->trans_date,"j M Y"),
            'due_date' => $this->helpers->format_mysql_date($supplierBill->due_date,"j M Y"),
            'order_number' => $supplierBill->order_number,
            'trans_number' => $supplierBill->trans_number,
            'ref_number' => $supplierBill->ref_number,
            'status' => $trans_status,
            'vendor' => $this->transform_supplier($supplierBill->suppliers()->get()->first()),
        ];

    }

    public function company_terms_initializations(Model $company){
        $company->supplier_terms()->create(['name'=>'net 15','notes'=>'full payment is expected within 10 days']);
        $company->supplier_terms()->create(['name'=>'net 30','notes'=>'full payment is expected within 30 days']);
        $company->supplier_terms()->create(['name'=>'net 45','notes'=>'full payment is expected within 45 days']);
        $company->supplier_terms()->create(['name'=>'net 60','notes'=>'full payment is expected within 60 days']);
        $company->supplier_terms()->create(['name'=>'2% 10, net 30','notes'=>"2% discount can be taken by the buyer only if payment is received in full within 10 days of the date of the invoice, and that full payment is expected within 30 days"]);
        $company->supplier_terms()->create(['name'=>'Due on Receipt','notes'=>"You're expected to be pay as soon as possible after you receive the invoice"]);
        $company->supplier_terms()->create(['name'=>'Due end of the month','notes'=>'full payment is expected end month']);
        $company->supplier_terms()->create(['name'=>'Due end of next month','notes'=>'full payment is expected end of next month']);
    }

}
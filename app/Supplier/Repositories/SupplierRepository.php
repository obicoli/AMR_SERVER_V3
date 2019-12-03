<?php

namespace App\Supplier\Repositories;

use App\Accounting\Models\COA\AccountChartAccount;
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
use App\Supplier\Models\SupplierBill;
use App\Supplier\Models\SupplierCompany;
use App\Supplier\Models\SupplierTerms;
use Illuminate\Support\Facades\DB;

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
    public function transform_supplier(Supplier $supplier, $detailed=false){
        
        //This supplier has accounting account number that keep track of all payments made to him/her 
        $account_holder = $supplier->account_holders()->get()->first();
        $account = [
            'id'=>$account_holder->uuid,
            'account_type'=>$account_holder->account_type,
            'account_number'=>$account_holder->account_number,
            'name'=>$account_holder->name,
            'main'=>$account_holder->main,
            'bonus'=>$account_holder->bonus,
            'balance'=>$account_holder->balance,
        ];

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
                'supplier_term'=>$term,
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

        $po_statuses = $purchaseOrder->po_status()->get();
        $trans_status = array();
        foreach ($po_statuses as $po_status) {
            $temp_status['id'] = $po_status->uuid;
            $temp_status['status'] = $po_status->status;
            $temp_status['note'] = $po_status->note;
            $temp_status['date'] = $this->helpers->format_mysql_date($po_status->created_at);
            $practice_user = $po_status->responsible()->get()->first();
            $temp_status['signatory'] = $this->companyUser->transform_user($practice_user);
            array_push($trans_status,$temp_status);
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
            $temp_item['amount'] = $toty;
            $temp_item['adjustments'] = $adjustments;
            array_push($po_items,$temp_item);
        }

        return [
            'id' => $purchaseOrder->uuid,
            'notes' => $purchaseOrder->notes,
            'po_date' => $this->helpers->format_mysql_date($purchaseOrder->po_date,"j M Y"),
            'trans_number' => $purchaseOrder->trans_number,
            'ref_number' => $purchaseOrder->ref_number,
            'vendor' => $this->transform_supplier( $purchaseOrder->suppliers()->get()->first(),true ),
            'total_grand' => 0,
            'po_due_date' => $this->helpers->format_mysql_date($purchaseOrder->po_due_date,"j M Y"),
            'status' => $trans_status,
            'bills' => null,
            'ship_to' => $purchaseOrder->ship_to,
            'shipping' => $shipping,
            'items' => $po_items,
            'other_total' => 0,
            'shipping_total' => 0,
            'taxation_option' => $purchaseOrder->taxation_option,
            'total_grand' => $total_without_discount_and_tax,
            'discount_allowed' => \round( $total_discount,2 ),
            'total_tax' => $total_taxe,
            'total_bill' => \round($total_without_discount_and_tax - $total_discount,2),
        ];
    }

    public function transform_bill(SupplierBill $supplierBill){

        return [
            'id' => $supplierBill->uuid,
            'notes' => $supplierBill->notes,
            'taxation_option' => $supplierBill->taxation_option,
            'bill_date' => $this->helpers->format_mysql_date($supplierBill->bill_date,"j M Y"),
            'bill_due_date' => $this->helpers->format_mysql_date($supplierBill->bill_due_date,"j M Y"),
            'order_number' => $supplierBill->order_number,
            'trans_number' => $supplierBill->trans_number,
            'ref_number' => $supplierBill->ref_number,
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
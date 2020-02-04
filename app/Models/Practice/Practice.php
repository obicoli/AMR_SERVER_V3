<?php

namespace App\Models\Practice;

use App\Accounting\Models\AccountHolder;
use App\Finance\Models\Banks\AccountsBank;
use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\COA\AccountsOpeningBalance;
use App\Accounting\Models\Payments\AccountPaymentType;
use App\Accounting\Models\Tax\AccountsVatReturn;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Assets\Models\Machines\Vehicle\Vehicle;
use App\Contracts\AccountableInterface;
use App\Customer\Models\Credits\CustomerCreditNote;
use App\Customer\Models\Customer;
use App\Customer\Models\CustomerPayment;
use App\Customer\Models\CustomerTerms;
use App\Customer\Models\Invoice\CustomerInvoice;
use App\Customer\Models\Invoice\CustomerRetainerInvoice;
use App\Customer\Models\Orders\CustomerSalesOrder;
use App\Customer\Models\Quote\Estimate;
use App\Customer\Models\Sales\CustomerSalesReceipt;
use App\Finance\Models\Banks\BankTransaction;
use App\Hrs\Models\Employee\HrsEmployee;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Practice\Inventory\PracticeAccountHolder;
use App\Models\Product\Accounts\ProductChartAccount;
use App\Models\Product\Accounts\ProductVoucher;
use App\Models\Product\Order\Order;
use App\Models\Product\ProductBank;
use App\Models\Product\ProductBrand;
use App\Models\Product\ProductBrandSector;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductCurrency;
use App\Models\Product\ProductPaymentMethod;
use App\Models\Product\ProductSalesCharge;
use App\Models\Product\ProductType;
use App\Models\Product\ProductUnit;
use App\Models\Product\Purchase\ProductPurchase;
use App\Models\Product\Sales\ProductPriceRecord;
use App\Models\Product\Sales\ProductSales;
// use App\Models\Supplier\Supplier;
use App\Models\Users\Activation;
use App\Models\Patient\Patient;
use App\Models\Account\Account;
use App\Models\Users\User;
use App\Traits\AccountableTrait;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Models\Inventory\Employee;
use App\Models\Product\Product;
use App\Models\Product\ProductGeneric;
use App\Models\Product\ProductAdministrationRoute;
use App\Traits\CoaTrait;
// use App\Models\Inventory\ProductStock;
use App\Models\Product\Inventory\ProductStock;
use App\Models\Inventory\ProductStockMovement;
use App\Models\Product\Store\ProductStore;
use App\Models\Account\Payments\AccountPaymentTransaction;
use App\Models\Product\Purchase\ProductPo;
use App\Models\Account\Vendors\AccountVendor;
use App\Models\His\Rtc\HisRtcUserTrack;
use App\Models\Module\Module;
use App\Models\NotificationCenter\Inventory\InventoryAlert;
use App\Models\Product\Inventory\ProductRequistion;
use App\Models\NotificationCenter\Inventory\NotificationInventoryMailbox;
use App\Models\NotificationCenter\Inventory\NotificationInventorySms;
use App\Models\Practice\Settings\DashboardSetting;
use App\Models\Product\Inventory\Inward\ProductStockInward;
use App\Models\Product\Inventory\ProductStockTaking;
use App\Models\Product\Purchase\GrnNote;
use App\Models\Product\Supply\GoodsOutNote;
use App\Models\Product\Supply\ProductSupply;
use App\Supplier\Models\PurchaseOrder;
use App\Supplier\Models\Supplier;
use App\Supplier\Models\SupplierBill;
use App\Supplier\Models\SupplierCompany;
use App\Supplier\Models\SupplierCredit;
use App\Supplier\Models\SupplierPayment;
use App\Supplier\Models\SupplierReturn;
use App\Supplier\Models\SupplierTerms;

class Practice extends Model implements AccountableInterface
{
    use SoftDeletes, Accountable,UuidTrait, AccountableTrait;

    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;

    const AC_VERIFICATION = "EMAIL VERIFICATION";
    const NAME_SPACE = "App\Models\Practice\Practice";
    const AC_NAME = "Practice";

    protected $table = 'practices';

    protected $guarded = ['id'];

    protected $account_type = Account::AC_HOSPITAL;

    protected $fillable = [
        'name',
        'city',
        'postal_code',
        'country',
        'uuid',
        'description',
        'email',
        'mobile',
        'address',
        'website',
        'latitude',
        'longitude',
        'type',
        'is_verified',
        'activated',
        'registration_number',
        'region',
        'fax',
        'propriator_title',
        'propriator_name',
        'business_type',
        'industry',
        'display_assigned_user',
        'inventory_increase',
        'inventory_descrease',
        'warehouse_config',
        'batch_tracking',
    ];

    //Columns Based functions
    public function getFinancePeriodStartDate(){ return $this->finance_yr_start; }
    public function getFinancePeriodEndDate(){ return $this->finance_yr_end; }

    //Settings
    public function practice_finance_settings(){ return $this->hasMany(PracticeFinanceSetting::class,'practice_id'); }
    public function dashboard_widgets(){ return $this->belongsToMany(DashboardSetting::class,'company_widgets','practice_id','widget_id'); }
    public function practice_taxations(){ return $this->hasMany(PracticeTaxation::class,'practice_id','id'); }

    //Supplier Module Integration
    public function vendors(){ return $this->morphMany(Supplier::class,'owning','owning_type','owning_id'); }
    public function supplier_bills(){ return $this->morphMany(SupplierBill::class,'owning','owning_type','owning_id'); }
    public function purchase_order_shipping(){ return $this->morphMany(PurchaseOrder::class,'shipable','shipable_type','shipable_id'); }
    public function purchase_orders(){ return $this->morphMany(PurchaseOrder::class,'owning','owning_type','owning_id'); }
    public function supplier_terms(){ return $this->morphMany(SupplierTerms::class,'owning','owning_type','owning_id'); }
    public function supplier_payments(){ return $this->morphMany(SupplierPayment::class,'owning','owning_type','owning_id'); }
    public function supplier_returns(){ return $this->morphMany(SupplierReturn::class,'owning','owning_type','owning_id'); }
    public function supplier_credits(){ return $this->morphMany(SupplierCredit::class,'owning','owning_type','owning_id'); }
    //Supplier Integration ends here

    //Accounting Integration=================================================
    public function accountOpeningBalances(){ return $this->morphMany(AccountsOpeningBalance::class,'owning','owning_type','owning_id'); }
    public function taxReturns(){ return $this->morphMany(AccountsVatReturn::class,'owning','owning_type','owning_id'); }
    public function coas(){ return $this->morphMany(AccountsCoa::class,'owning','owning_type','owning_id'); }
    public function accounts_payment_methods(){ return $this->morphMany(AccountPaymentType::class,'owning','owning_type','owning_id'); }
    public function chart_of_accounts(){ return $this->morphMany(AccountChartAccount::class,'owning','owning_type','owning_id'); }
    public function vouchers(){ return $this->morphMany(AccountsVoucher::class,'owner','owner_type','owner_id'); }
    public function bank_accounts(){ return $this->morphMany(AccountsBank::class,'owner','owner_type','owner_id'); }
    public function account_holders(){ return $this->hasMany(AccountHolder::class,'practice_id'); }
    //Accounting Integration Ends============================================

    //Customer Integration===========Starts============= 54
    public function customer_payments(){ return $this->morphMany(CustomerPayment::class,'owning','owning_type','owning_id'); }
    public function estimates(){ return $this->morphMany(Estimate::class,'owning','owning_type','owning_id'); }
    public function customerSalesorder(){ return $this->morphMany(CustomerSalesOrder::class,'owning','owning_type','owning_id'); }
    public function customerInvoices(){ return $this->morphMany(CustomerInvoice::class,'owning','owning_type','owning_id'); }
    public function retainerInvoices(){ return $this->morphMany(CustomerRetainerInvoice::class,'owning','owning_type','owning_id'); }
    public function salesReceipts(){ return $this->morphMany(CustomerSalesReceipt::class,'owning','owning_type','owning_id'); }
    public function customerCreditNotes(){ return $this->morphMany(CustomerCreditNote::class,'owning','owning_type','owning_id'); }
    public function customer_terms(){ return $this->morphMany(CustomerTerms::class,'owning','owning_type','owning_id'); }
    public function customers(){ return $this->morphMany(Customer::class,'owning','owning_type','owning_id'); }
    //Customer Integration===========Ends=============



    //Banking Integration Starts here
    public function bank_transactions(){ return $this->morphMany(BankTransaction::class,'owning','owning_type','owning_id'); }
    //Banking Integration Ends Here

    //Assets: 
    public function vehicles(){ return $this->morphMany(Vehicle::class,'owning','owning_type','owning_id'); }
    //HRS
    public function employees(){ return $this->morphMany(HrsEmployee::class,'owning','owning_type','owning_id'); }
    //
    public function grn_deliverylocation(){ return $this->morphMany(GrnNote::class,'deliverylocation','deliverylocation_type','deliverylocation_id');  }
    //His RTC Tracks
    public function his_rtc_tracks(){ return $this->morphMany(HisRtcUserTrack::class,'owning','owning_type','owning_id'); }
    public function product_email_notifications(){ return $this->morphMany(NotificationInventoryMailbox::class,'owning'); }
    public function product_sms_notifications(){ return $this->morphMany(NotificationInventorySms::class,'owning'); }
    public function product_notifications(){ return $this->morphMany(InventoryAlert::class,'owning','owning_type','owning_id'); }
    //Product based
    public function product_suppliers(){ return $this->morphMany(SupplierCompany::class,'owning','owning_type','owning_id'); }
    public function product_stocks(){ return $this->morphMany(ProductStock::class,'owning','owning_type','owning_id'); }
    public function product_stock_inward(){ return $this->morphMany(ProductStockInward::class,'owning','owning_type','owning_id'); }
    //
    //public function product_stock_movement(){ return $this->morphMany(ProductStockMovement::class,'owner','owner_type','owner_id'); }
    //public function product_type(){ return $this->belongsToMany(ProductType::class,'practice_product_type','practice_id','product_type_id'); }
    public function product_type(){ return $this->hasMany(ProductType::class,'practice_id'); }
    public function product_items(){ return $this->hasMany(PracticeProductItem::class, 'practice_id'); }
    public function product_sales(){ return $this->hasMany(ProductSales::class,'practice_id'); }
    public function product_price_record(){ return $this->hasMany(ProductPriceRecord::class,'practice_id'); }
    public function sales_charge(){ return $this->hasMany(ProductSalesCharge::class,'practice_id'); }
    public function product_requisitions_src(){ return $this->morphMany(ProductRequistion::class, 'src_owning','src_owning_type','src_owning_id'); }
    public function product_requisitions_dest(){ return $this->morphMany(ProductRequistion::class, 'destination_owner','dest_owning_type','dest_owning_id'); }
    //
    public function product_supply_src(){ return $this->morphMany(ProductSupply::class, 'src_owning','src_owning_type','src_owning_id'); }
    public function product_supply_dest(){ return $this->morphMany(ProductSupply::class, 'destination_owner','dest_owning_type','dest_owning_id'); }
    //public function vouchers(){ return $this->hasMany(ProductVoucher::class,'practice_id'); }
    public function chart_accounts(){ return $this->hasMany(ProductChartAccount::class,'practice_id'); }
    public function product_category(){ return $this->hasMany(ProductCategory::class,'practice_id'); }
    public function product_brands(){ return $this->hasMany(ProductBrand::class,'practice_id'); }
    public function product_brand_sector(){ return $this->hasMany(ProductBrandSector::class,'practice_id'); }
    public function product_units(){ return $this->hasMany(ProductUnit::class,'practice_id'); }
    //public function product_currency(){ return $this->hasMany(ProductCurrency::class,'practice_id'); }
    //public function employees(){ return $this->hasMany(Employee::class, 'practice_id'); }
    public function products(){
        // return $this->hasMany(Product::class, 'practice_id'); 
    }
    public function generics(){ return $this->hasMany(ProductGeneric::class, 'practice_id'); }
    public function product_route(){ return $this->hasMany(ProductAdministrationRoute::class,'practice_id'); }
    //public function manufacturers(){ return $this->morphMany(PracticeAccountHolder::class, 'owner','owner_type','owner_id'); }
    public function practice_account_holder(){ return $this->morphMany(PracticeAccountHolder::class, 'owner','owner_type','owner_id'); }
    //public function suppliers(){ return $this->belongsToMany(Supplier::class,'product_practice_suppliers','practice_id','supplier_id'); }
    //public function manufacturers(){ return $this->belongsToMany(Manufacturer::class,'practice_manufacturers','practice_id','manufacturer_id'); }
    //public function payment_methods(){ return $this->hasMany(ProductPaymentMethod::class,'practice_id'); }
    //public function bank_accounts(){ return $this->morphMany(AccountsBank::class,'holderable','holder_type','holder_id'); }
    
    //public function purchases(){ return $this->hasMany(ProductPurchase::class,'practice_id'); }
    //public function purchases(){ return $this->morphMany(ProductPurchase::class,'owner'); }
    //public function purchase_orders(){ return $this->morphMany(ProductPo::class, 'owning','owning_type','owning_id'); }
    //public function delivered_locations(){ return $this->morphMany(ProductPo::class, 'deliverable','deliverable_type','deliverable_id'); }
    //public function charged_locations(){ return $this->morphMany(ProductPo::class, 'chargeable','chargeable_type','chargeable_id'); }
    public function purchases(){ return $this->morphMany(ProductPurchase::class, 'owning','owning_type','owning_id'); }
    //public function payments(){ return $this->morphMany(AccountPaymentTransaction::class,'owning','owning_type','owning_id'); }
    // public function chart_of_accounts(){ return $this->morphMany(AccountChartAccount::class,'owning','owning_type','owning_id'); }
    //public function vendors(){ return $this->morphMany(AccountVendor::class,'owning','owning_type','owning_id'); }
    public function product_goods_out_note(){ return $this->morphMany(GoodsOutNote::class,'owning','owning_type','owning_id'); }
    public function product_stock_taking(){ return $this->morphMany(ProductStockTaking::class,'owning','owning_type','owning_id'); }

    //stores
    //public function stores(){ return $this->hasMany(PracticeStore::class, 'practice_id'); }
    public function stores(){ return $this->morphMany(ProductStore::class,'store_locatable','store_locatable_type','store_locatable_id'); }
    public function departments(){ return $this->belongsToMany(Department::class,'practice_departments','practice_id','department_id'); }
    //departments
    //public function department(){ return $this->belongsToMany(Department::class, 'practice_departments','department_id','practice_id'); }
    //practice owners
    public function owner(){return $this->morphTo('owner','owner_type','owner_id');}
    //practice user
    public function user(){return $this->belongsToMany(User::class,'practices_users','user_id','practice_id');}
    //practice users & there associated roles and permissions
    public function users(){ return $this->hasMany(PracticeUser::class,'practice_id'); }
    //Roles
    public function roles(){ return $this->hasMany(PracticeRole::class,'practice_id'); }

    public function assets(){
        return $this->morphMany(PracticeAsset::class, 'assetable');
    }

    public function orders(){return $this->morphMany(Order::class,'orderable','owner_type','owner_id','id');}

    //public function doctor(){return $this->morphedByMany(Doctor::class, 'practiceable');}

    public function patient(){return $this->morphedByMany(Patient::class, 'practiceable');}
    //prefered pharmacy
    public function preferred_pharmacy(){return $this->belongsToMany(Patient::class,'patient_pharmacy','practice_id','patient_id');}

    public function activation()
    {
        return $this->morphMany(Activation::class, 'activationable','owner_type','owner_id');
    }

    public function getAccountName()
    {
        return $this->phone;
    }

    public function getAccountId()
    {
        return $this->id;
    }

    public function getAccountType()
    {
        return $this->account_type;
    }

}

<?php

namespace App\Models\Hospital;

// use App\Hrs\Models\HrsEmployee;

use App\Accounting\Models\Tax\AccountsTaxation;
use App\Assets\Models\Machines\Vehicle\Vehicle;
use App\Hrs\Models\Employee\HrsEmployee;
use App\Models\Practice\PracticeProductItem;
use App\Traits\AccountableTrait;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Account\Account;
use App\Models\Practice\Practice;
use App\Models\Practice\Department;
use App\Models\Product\Product;
use App\Models\Product\ProductGeneric;
use App\Models\Product\ProductBrand;
use App\Models\Product\ProductBrandSector;
use App\Models\Product\ProductCurrency;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductUnit;
use App\Models\Product\ProductType;
use App\Models\Product\ProductSalesCharge;
use App\Models\Account\Banks\AccountsBank;
use App\Models\Account\Vendors\AccountVendor;
use App\Models\Product\Store\ProductStore;
use App\Models\Product\Purchase\ProductPurchase;
use App\Models\Account\Payments\AccountPaymentType;
use App\Models\Account\Payments\AccountPaymentMethod;
use App\Models\Account\Payments\AccountPaymentTransaction;
use App\Models\Account\COA\AccountChartAccount;
use App\Models\His\Rtc\HisRtcUserTrack;
use App\Models\NotificationCenter\Inventory\InventoryAlert;
use App\Models\NotificationCenter\Inventory\NotificationInventoryMailbox;
use App\Models\Product\Inventory\Inward\ProductStockInward;
use App\Models\Product\Inventory\ProductRequistion;
use App\Models\Product\Purchase\ProductPo;
use App\Models\Product\Inventory\ProductStock;
use App\Models\Product\Inventory\ProductStockTaking;
use App\Models\Product\ProductAdministrationRoute;
use App\Models\Product\Profile\ProductProfile;
use App\Models\Product\ProductFormulation;
use App\Models\Product\ProductItem;
use App\Models\Product\ProductManufacture;
use App\Models\Product\ProductOrderCategory;
use App\Models\Product\ProductSubCategory;
use App\Models\Product\ProductSupplier;
use App\Models\Product\ProductTaxation;
use App\Models\Product\Vaccine\ProductVaccine;
use App\Models\Product\Route\ProductRoutes;
use App\Models\Product\Supply\GoodsOutNote;
use App\Models\Product\Supply\ProductSupply;
use App\Supplier\Models\SupplierCompany;

class Hospital extends Model
{

    use SoftDeletes,UuidTrait, Accountable, AccountableTrait;

    protected $table = "hospitals";

    protected $guarded = [
        'id'
    ];

    protected $account_type = Account::AC_HOSPITAL;

    protected $fillable = [
        'name',
        'city',
        'country',
        'postal_code',
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
    ];

    //Accountings
    public function accounts_taxations(){ return $this->morphMany(AccountsTaxation::class,'owner','owner_type','owner_id'); }

    //ASSETS
    public function vehicles(){return $this->morphMany(Vehicle::class,'owner','owner_type','owner_id');}
    //HRS
    public function employees(){return $this->morphMany(HrsEmployee::class,'owner','owner_type','owner_id');}
    public function practices(){return $this->morphMany(Practice::class,'owner','owner_type','owner_id');}
    public function departments(){return $this->morphMany(Department::class,'owner','owner_type','owner_id');}
    //Product based
    //public function product_type(){ return $this->belongsToMany(ProductType::class,'practice_product_type','practice_id','product_type_id'); }
    
    
    // public function product_sales(){ return $this->morphMany(ProductSales::class,'owner'); }
    // public function product_price_record(){ return $this->morphMany(ProductPriceRecord::class,'owner'); }
    //Product Goods Out Notes
    public function product_goods_out_note(){ return $this->morphMany(GoodsOutNote::class,'owner','owner_type','owner_id'); }
    public function product_stock_taking(){ return $this->morphMany(ProductStockTaking::class,'owner','owner_type','owner_id'); }
    
    
    // public function vouchers(){ return $this->morphMany(ProductVoucher::class,'owner'); }
    // public function chart_accounts(){ return $this->morphMany(ProductChartAccount::class,'owner'); }


    
    // public function product_currency(){ return $this->morphMany(ProductCurrency::class,'owner'); }
    public function product_email_notifications(){ return $this->morphMany(NotificationInventoryMailbox::class,'owner'); }
    public function product_stocks(){ return $this->morphMany(ProductStock::class,'owner','owner_type','owner_id'); }
    public function product_notifications(){ return $this->morphMany(InventoryAlert::class,'owner','owner_type','owner_id'); }
    //public function employees(){ return $this->morphMany(Employee::class, 'practice_id'); }

    //---------------------------------Product Integration Module--------------------------
    public function product_items(){ return $this->morphMany(ProductItem::class, 'owner','owner_type','owner_id'); }
    public function products(){ return $this->morphMany(Product::class, 'owner');}
    public function product_profiles(){ return $this->morphMany(ProductProfile::class, 'owner','owner_type','owner_id'); }
    public function product_type(){ return $this->morphMany(ProductType::class,'owner','owner_type','owner_id'); }
    public function product_units(){ return $this->morphMany(ProductUnit::class,'owner','owner_type','owner_id'); }
    public function product_brands(){ return $this->morphMany(ProductBrand::class,'owner'); }
    public function product_brand_sector(){ return $this->morphMany(ProductBrandSector::class,'owner','owner_type','owner_id'); }
    public function product_suppliers(){ return $this->morphMany(SupplierCompany::class,'owner','owner_type','owner_id'); }
    public function product_manufacturers(){ return $this->morphMany(ProductManufacture::class,'owner','owner_type','owner_id'); }
    public function product_category(){ return $this->morphMany(ProductCategory::class,'owner','owner_type','owner_id'); }
    public function product_sub_category(){ return $this->morphMany(ProductSubCategory::class,'owner','owner_type','owner_id'); }
    public function product_order_category(){ return $this->morphMany(ProductOrderCategory::class,'owner','owner_type','owner_id'); }
    public function generics(){ return $this->morphMany(ProductGeneric::class, 'owner','owner_type','owner_id'); }
    public function product_formulations(){ return $this->morphMany(ProductFormulation::class, 'owner','owner_type','owner_id'); }
    public function product_route(){ return $this->morphMany(ProductAdministrationRoute::class,'owner','owner_type','owner_id'); }
    public function sales_charge(){ return $this->morphMany(ProductSalesCharge::class,'owner','owner_type','owner_id'); }
    public function product_taxations(){ return $this->morphMany(ProductTaxation::class,'owner','owner_type','owner_id'); }
    //-----------------------------------------------------------
    
    
    public function purchases(){ return $this->morphMany(ProductPurchase::class, 'owner','owner_type','owner_id'); }
    //public function purchase_orders(){ return $this->morphMany(ProductPo::class, 'owner','owner_type','owner_id'); }
    
    
    public function product_vaccines(){ return $this->morphMany(ProductVaccine::class, 'owner','owner_type','owner_id'); }
    public function product_routes(){ return $this->morphMany(ProductRoutes::class, 'owner','owner_type','owner_id'); }
    public function product_requisitions(){ return $this->morphMany(ProductRequistion::class, 'owner','owner_type','owner_id'); }
    public function product_supply(){ return $this->morphMany(ProductSupply::class, 'owner','owner_type','owner_id'); }
    public function product_stock_inward(){ return $this->morphMany(ProductStockInward::class, 'owner','owner_type','owner_id'); }
    //accounting
    //public function banks(){ return $this->morphMany(AccountsBank::class,'owner','owner_type','owner_id'); }
    public function vendors(){ return $this->morphMany(AccountVendor::class,'owner','owner_type','owner_id'); }
    public function stores(){ return $this->morphMany(ProductStore::class,'owner','owner_type','owner_id'); }
    // public function payment_types(){ return $this->morphMany(AccountPaymentType::class,'owner','owner_type','owner_id'); }
    // public function payment_method(){ return $this->morphMany(AccountPaymentMethod::class,'owner','owner_type','owner_id'); }
    // public function payments(){ return $this->morphMany(AccountPaymentTransaction::class,'owner','owner_type','owner_id'); }
    // public function chart_of_accounts(){ return $this->morphMany(AccountChartAccount::class,'owner','owner_type','owner_id'); }
    //His RTC Tracks
    public function his_rtc_tracks(){ return $this->morphMany(HisRtcUserTrack::class,'owner','owner_type','owner_id'); }

    public function getAccountType()
    {
        // TODO: Implement getAccountType() method.
        return $this->account_type;
    }

    public function getAccountId()
    {
        // TODO: Implement getAccountId() method.
        return $this->id;
    }

    public function getAccountName()
    {
        // TODO: Implement getAccountName() method.
        return $this->name;
    }

    public function getOrCreate($id, array $data)
    {
        $sup = self::query()->where("id", $id)->firstOrFail();

        if (!$sup) {
            $sup = self::query()->create($data);

            return $sup;
        }

        return $sup;
    }

}

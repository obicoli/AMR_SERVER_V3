<?php

namespace App\Models\Product;

use App\Customer\Models\Quote\Estimate;
use App\Models\Account\Vendors\AccountVendor;
use App\Models\Product\ProductSalesCharge;
use App\Models\Product\Purchase\ProductPurchaseItem;
use App\Models\Product\Sales\ProductPriceRecord;
use App\Models\Product\Sales\ProductSaleItem;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use App\ProductItemTaxes;
use App\Models\Product\Inventory\ProductStock;
use App\Models\Inventory\ProductStockMovement;
use App\Models\Module\Module;
use App\Models\Product\Inventory\Inward\ProductStockInward;
use App\Models\Product\Inventory\ProductRequistionItem;
use App\Models\Product\ProductSubCategory;
use App\Models\Product\Purchase\GrnNoteItem;
use App\Models\Product\ProductOrderCategory;
use App\Models\Product\Route\ProductRoutes;
use App\Supplier\Models\SupplierBillItem;
use App\Supplier\Models\SupplierCompany;

class ProductItem extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;
    protected $table = "product_items";

    //Columns
    const COL_ITEM_CODE = "item_code";
    protected $fillable = [
        'product_id',
        'product_id',
        'manufacturer_id',
        'product_type_id',
        'product_category_id',
        'product_sub_category_id',
        'product_route_id',
        'product_unit_id',
        'product_brand_id',
        'product_brand_sector_id',
        'product_unit_id',
        'product_order_category_id',
        'product_formulation_id',
        'prefered_supplier_id',
        'product_profile_id',
        'product_manufacturer_id',
        'item_code',
        'barcode',
        'status',
        'confirmed',
        'item_note',
        'unit_storage_location',
        'single_unit_weight',
        'net_weight',
        'alert_indicator_level',
        'units_per_pack',
    ];

    //Attributes based Relationship
    public function taxations(){ return $this->belongsToMany(ProductTaxation::class,'product_item_taxations','product_item_id','product_taxation_id'); }
    public function brands(){ return $this->belongsTo(ProductBrand::class,'product_brand_id'); }
    public function product_types(){ return $this->belongsTo(ProductType::class,'product_type_id'); }
    public function profiles(){ return $this->belongsTo(ProductProfile::class,'product_profile_id'); }
    public function product_generic(){ return $this->belongsTo(ProductGeneric::class,'generic_id'); }
    public function units_of_measure(){ return $this->belongsTo(ProductUnit::class,'product_unit_id'); }
    public function brand_sectors(){ return $this->belongsTo(ProductBrandSector::class,'product_brand_sector_id'); }
    public function products(){ return $this->belongsTo(Product::class,'product_id'); }
    public function product_category(){ return $this->belongsTo(ProductCategory::class,'product_category_id'); }
    public function product_routes(){ return $this->belongsTo(ProductRoutes::class,'product_route_id'); }
    public function product_sub_category(){ return $this->belongsTo(ProductSubCategory::class,'product_sub_category_id'); }
    public function product_order_category(){ return $this->belongsTo(ProductOrderCategory::class,'product_order_category_id'); }
    public function product_formulations(){ return $this->belongsTo(ProductFormulation::class,'product_formulation_id'); }
    public function prefered_suppliers(){ return $this->belongsTo(SupplierCompany::class,'prefered_supplier_id'); }
    public function product_manufacturer(){ return $this->belongsTo(ProductManufacture::class,'product_manufacturer_id'); }
    //Customer Integrated
    public function estimates(){ return $this->hasMany(Estimate::class,'product_item_id'); }
    //Suppliers Module
    public function supplier_bill_items(){ return $this->hasMany(SupplierBillItem::class,'product_item_id'); }
    //Other
    public function stocks(){ return $this->hasMany(ProductStock::class, 'product_item_id'); }
    public function product_stock_inward(){ return $this->hasMany(ProductStockInward::class, 'product_item_id'); }
    public function grn_note_items(){ return $this->hasMany(GrnNoteItem::class, 'product_item_id'); }
    public function stock_movement(){ return $this->hasMany(ProductStockMovement::class, 'product_item_id'); }
    public function price_record(){ return $this->hasMany(ProductPriceRecord::class, 'practice_product_item_id'); }
    public function sales_charges(){ return $this->belongsToMany(ProductSalesCharge::class,'pract_prod_sale_charges','practice_product_item_id','product_sales_charge_id'); }
    public function purchases(){ return $this->hasMany(ProductPurchaseItem::class, 'practice_product_item_id'); }
    public function sales(){ return $this->hasMany(ProductSaleItem::class, 'practice_product_item_id'); }
    public function product_requisitions(){ return $this->hasMany(ProductRequistionItem::class,'product_item_id'); }
    // public function product_taxes()
    // {
    //     return $this->morphMany(ProductItemTaxes::class, 'taxiable','taxiable_type','taxiable_id');
    // }
}

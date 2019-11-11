<?php

namespace App\Models\Practice;

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

class PracticeProductItem extends Model
{
    use SoftDeletes, Accountable, UuidTrait;
    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;
    protected $table = "practice_product_items";
    protected $fillable = [
        'product_id',
        'generic_id',
        'manufacturer_id',
        'product_type_id',
        'product_category_id',
        'product_route_id',
        'product_unit_id',
        'product_brand_id',
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
        //'product_currency_id',
        'product_brand_sector_id',
    ];

    public function owner()
    {
        return $this->morphTo();
    }

    //Attributes based Relationship:
    public function product_sub_category(){ return $this->belongsTo(ProductSubCategory::class,'product_sub_category_id'); }
    public function product_order_category(){ return $this->belongsTo(ProductOrderCategory::class,'product_order_category_id'); }
    
    public function stocks(){ return $this->hasMany(ProductStock::class, 'product_item_id'); }
    public function product_stock_inward(){ return $this->hasMany(ProductStockInward::class, 'product_item_id'); }
    public function grn_note_items(){ return $this->hasMany(GrnNoteItem::class, 'product_item_id'); }
    public function stock_movement(){ return $this->hasMany(ProductStockMovement::class, 'product_item_id'); }
    public function price_record(){ return $this->hasMany(ProductPriceRecord::class, 'practice_product_item_id'); }
    public function sales_charges(){ return $this->belongsToMany(ProductSalesCharge::class,'pract_prod_sale_charges','practice_product_item_id','product_sales_charge_id'); }
    public function purchases(){ return $this->hasMany(ProductPurchaseItem::class, 'practice_product_item_id'); }
    public function sales(){ return $this->hasMany(ProductSaleItem::class, 'practice_product_item_id'); }
    public function product_requisitions(){ return $this->hasMany(ProductRequistionItem::class,'product_item_id'); }
    public function product_taxes()
    {
        return $this->morphMany(ProductItemTaxes::class, 'taxiable','taxiable_type','taxiable_id');
    }

}

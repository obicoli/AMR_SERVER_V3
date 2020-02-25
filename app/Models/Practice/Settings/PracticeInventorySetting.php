<?php

namespace App\Models\Practice\Settings;

use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ByTestGear\Accountable\Traits\Accountable;

class PracticeInventorySetting extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_DB_CONN;
    protected $table = "practice_inventory_settings";
    protected $fillable = [
        'practice_id',
        'warn_item_qty_zero',
        'disallow_qty_zero',
        'warn_item_cost_zero',
        'warn_item_selling_zero',
        'warn_item_sale_below_cost',
        'show_inactive_items',
        'show_inactive_item_category',
        'sales_order_reserve_item',
        'batch_tracking',
        'barcode_tracking',
        'multi_warehouse_management',
    ];
    public function getUuid(){ return $this->uuid; }
    public function getWarnItemQtyZero(){ return $this->warn_item_qty_zero; }
    public function getDisallowQtyZero(){ return $this->disallow_qty_zero; }
    public function getWarnItemCostZero(){ return $this->warn_item_cost_zero; }
    public function getWarnItemSaleZero(){ return $this->warn_item_selling_zero; }
    public function getWarnSalesBelowCost(){ return $this->warn_item_sale_below_cost; }
    public function getShowInactiveItem(){ return $this->show_inactive_items; }
    public function getInactiveItemCategory(){ return $this->show_inactive_item_category; }
    public function getSalesOrderReserveItem(){ return $this->sales_order_reserve_item; }
    public function getBatchTracking(){ return $this->batch_tracking; }
    public function getBarcodeTracking(){ return $this->barcode_tracking; }
    public function getMultiWarehouseManagement(){ return $this->multi_warehouse_management; }
    public function practices(){ return $this->hasOne(PracticeInventorySetting::class,'practice_id','id'); }
}

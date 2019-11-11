<?php

namespace App\Models\Product\Inventory;

use App\Models\Practice\Department;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Practice\PracticeProductItem;
use App\Models\Product\Store\ProductStore;
use App\Models\Product\Inventory\Inward\ProductStockInward;
use App\Models\Product\Inventory\Outward\ProductStockOutward;
use App\Models\Product\Inventory\Outward\ProductStockSale;
use App\Models\Product\Sales\ProductPriceRecord;

class ProductStock extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'product_stocks';

    protected $fillable = [
        'amount',
        // 'batch_number',
        // 'batch_number',
        'source_type',
        'product_item_id',
        'product_item_price_id',
        'status',
    ];

    public function owner(){return $this->morphTo();} //Enterprise Owning
    public function owning(){return $this->morphTo();} //Branch Owning
    public function sourceable(){return $this->morphTo();} //Source of Stock

    public function stock_outwards(){ return $this->hasMany(ProductStockOutward::class,'product_stock_id'); }
    public function stock_inwards(){ return $this->hasMany(ProductStockInward::class,'product_stock_id'); }

    public function departments(){ return $this->belongsTo(Department::class,'department_id'); }
    public function stores(){ return $this->belongsTo(ProductStore::class,'store_id'); }
    public function sub_stores(){ return $this->belongsTo(ProductStore::class,'sub_store_id'); }

    public function product_stock_movement(){
        return $this->hasMany(ProductStockMovement::class,'product_stock_id');
    }

    public function product_items(){ return $this->belongsTo(PracticeProductItem::class,'product_item_id'); }
    public function prices(){ return $this->belongsTo(ProductPriceRecord::class,'product_item_price_id'); }
    //product_stock_id
    public function sales(){
        return $this->hasMany(ProductStockSale::class,'product_stock_id');
    }

}

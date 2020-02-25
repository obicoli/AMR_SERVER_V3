<?php

namespace App\Models\Product\Store;

use App\Models\His\Rtc\HisRtcUserTrack;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Models\Product\Inventory\Inward\ProductStockInward;
use App\Models\Product\Inventory\ProductRequistion;
use App\Models\Product\Inventory\ProductStock;
use App\Models\Product\Inventory\ProductStockTaking;
use App\Models\Product\Purchase\GrnNote;
use App\Models\Product\Supply\ProductSupply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;

class ProductStore extends Model
{
    use SoftDeletes, Accountable,UuidTrait;
    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;
    protected $table = "product_stores";
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'status',
        'is_default',
    ];

    public function getUuid(){ return $this->uuid; }
    public function getName(){ return $this->name; }
    public function getEmail(){ return $this->email; }
    public function getMobile(){ return $this->mobile; }
    public function getStatus(){ return $this->status; }
    public function getIsDefault(){ return $this->is_default; }

    public function practices(){ return $this->belongsTo(Practice::class,'practice_id','id'); }

    public function owner(){ return $this->morphTo();}
    public function store_locatable(){ return $this->morphTo();}
    public function his_rtc_tracks_store(){ return $this->hasMany(HisRtcUserTrack::class,'store_id'); }
    public function his_rtc_tracks_sub_store(){ return $this->hasMany(HisRtcUserTrack::class,'sub_store_id'); }
    public function product_requisition_src(){ return $this->hasMany(ProductRequistion::class,'src_store_id'); }
    public function product_requisition_dest(){ return $this->hasMany(ProductRequistion::class,'dest_store_id'); }

    public function product_requisition_substore_src(){ return $this->hasMany(ProductRequistion::class,'src_sub_store_id'); }
    public function product_requisition_substore_dest(){ return $this->hasMany(ProductRequistion::class,'dest_sub_store_id'); }
    public function product_stocks(){ return $this->hasMany(ProductStock::class,'store_id'); }
    public function product_stock_inward(){ return $this->hasMany(ProductStockInward::class,'store_id');  } //product_stock_inward_sub_store
    public function product_stock_inward_sub_store(){ return $this->hasMany(ProductStockInward::class,'sub_store_id');  } //
    public function product_sub_stocks(){ return $this->hasMany(ProductStock::class,'sub_store_id'); }

    public function grn_store_notes(){ return $this->hasMany(GrnNote::class,'store_id'); }
    public function grn_sub_store_notes(){ return $this->hasMany(GrnNote::class,'sub_store_id'); }

    public function product_supply_src(){ return $this->hasMany(ProductSupply::class,'src_store_id'); }
    public function product_supply_dest(){ return $this->hasMany(ProductSupply::class,'dest_store_id'); }

    public function product_supply_substore_src(){ return $this->hasMany(ProductSupply::class,'src_sub_store_id'); }
    public function product_supply_substore_dest(){ return $this->hasMany(ProductSupply::class,'dest_sub_store_id'); }

    public function product_stock_taking_sub_store(){ return $this->hasMany(ProductStockTaking::class,'sub_store_id'); }
    public function product_stock_taking(){ return $this->hasMany(ProductStockTaking::class,'store_id'); }

}

<?php

namespace App\Models\Practice;

use App\Models\His\Rtc\HisRtcUserTrack;
use App\Models\Product\Inventory\ProductRequistion;
use App\Models\Product\Inventory\ProductStock;
use App\Models\Product\Inventory\Inward\ProductStockInward;
use App\Models\Product\Inventory\ProductStockTaking;
use App\Models\Product\Purchase\GrnNote;
use App\Models\Product\Purchase\ProductPo;
use App\Models\Product\Supply\ProductSupply;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{

    use Accountable, SoftDeletes, UuidTrait;

    const DEFAULT_AVATAR = "/assets/icons/department_1.png";
    const AVATAR_PATH = "/assets/icons/department_1.png";

    protected $table = 'departments';
    protected $fillable = [
        'name',
        'status',
        'description',
        'owner_id',
        'owner_type',
    ];

    public function owner()
    {
        return $this->morphTo();
    }
    public function practices(){ return $this->belongsToMany(Practice::class,'practice_departments','department_id','practice_id'); }
    public function practice_users(){ return $this->hasMany(PracticeUser::class,'department_id'); }
    public function his_rtc_tracks(){ return $this->hasMany(HisRtcUserTrack::class,'department_id'); }
    public function product_requisitions_src(){ return $this->hasMany(ProductRequistion::class,'src_department_id'); }
    public function product_requisitions_dest(){ return $this->hasMany(ProductRequistion::class,'dest_department_id'); }
    //Supply
    public function product_supply_src(){ return $this->hasMany(ProductSupply::class,'src_department_id'); }
    public function product_supply_dest(){ return $this->hasMany(ProductSupply::class,'dest_department_id'); }
    //
    public function product_stocks(){ return $this->hasMany(ProductStock::class,'department_id'); }
    public function product_pos(){ return $this->hasMany(ProductPo::class,'department_id'); }

    public function grn_notes(){ return $this->hasMany(GrnNote::class,'department_id'); }
    public function product_stock_inward(){ return $this->hasMany(ProductStockInward::class,'department_id'); }
    public function product_stock_taking(){ return $this->hasMany(ProductStockTaking::class,'department_id'); }

    //departments
    //public function practice(){ return $this->belongsToMany(Practice::class, 'practice_departments','practice_id','department_id'); }

}

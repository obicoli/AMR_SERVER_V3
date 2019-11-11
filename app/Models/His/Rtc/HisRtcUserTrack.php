<?php

namespace App\Models\His\Rtc;

use App\Models\Practice\Department;
use App\Models\Product\Store\ProductStore;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HisRtcUserTrack extends Model
{
    const RTC_SERVICE = "service";
    const RTC_SERVICE_ACTION = "service_action";
    const RTC_SERVICE_POSTED_DATA = "posted_data";
    const RTC_SERVICE_POSTED_BY = "posted_by";
    protected $table = 'his_rtc_user_tracks';
    protected $fillable = [
        'service_type',
        'service_action',
        'first_name',
        'last_name',
        'resource_id',
    ];

    public function owner(){ return $this->morphTo();} //Enterprise
    public function owning(){ return $this->morphTo();} //Enterprise
    //store
    public function stores(){ return $this->belongsTo(ProductStore::class,'store_id','id'); }
    public function substores(){ return $this->belongsTo(ProductStore::class,'sub_store_id','id'); }
    public function departments(){ return $this->belongsTo(Department::class,'department_id','id'); }

}

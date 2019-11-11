<?php

namespace App\Models\Practice;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Practice\Department;
use App\Models\Product\Store\ProductStore;

class PracticeUserWorkPlace extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = "practice_user_work_places";

    protected $fillable = [
        'practice_id',
        'department_id',
        'store_id',
        'sub_store_id',
        'practice_user_id',
        'started_at',
        'ended_at',
        'status',
    ];

    public function practice_user(){ return $this->belongsTo(PracticeUser::class,'practice_user_id'); }
    public function practice(){ return $this->belongsTo(Practice::class,'practice_id'); }
    public function departments(){ return $this->belongsTo(Department::class,'department_id','id'); }
    public function stores(){ return $this->belongsTo(ProductStore::class,'store_id','id'); }
    public function sub_stores(){ return $this->belongsTo(ProductStore::class,'sub_store_id','id'); }
    // public function departments(){ return $this->belongsTo(Department::class,'department_id','id'); }
    // public function stores(){ return $this->belongsTo(ProductStore::class,'store_id','id'); }
}

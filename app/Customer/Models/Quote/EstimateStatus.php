<?php

namespace App\Customer\Models\Quote;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstimateStatus extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "estimate_statuses";
    protected $fillable = [
        'status',
    ];

    public function responsible(){ return $this->morphTo();}
    public function estimates(){ return $this->belongsTo(Estimate::class,'estimate_id'); }
}

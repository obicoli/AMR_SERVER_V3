<?php

namespace App\Customer\Models\Quote;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstimateAssets extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "estimate_assets";
    protected $fillable = [
        'estimate_id',
        'file_path',
        'file_mime',
        'file_name',
        'file_size',
    ];
    public function estimate_status(){ return $this->hasMany(EstimateStatus::class,'estimate_id');}
}

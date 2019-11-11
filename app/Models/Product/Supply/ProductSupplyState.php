<?php

namespace App\Models\Product\Supply;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSupplyState extends Model
{
    use SoftDeletes, UuidTrait;
    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;
    protected $table = "product_supply_states";
    protected $fillable = [
        'status',
        'note',
        'product_supply_id'
    ];

    public function responsible(){ return $this->morphTo();}

    public function product_supply(){ return $this->belongsTo(ProductSupply::class,'product_supply_id'); }

}

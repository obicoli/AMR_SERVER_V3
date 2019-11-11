<?php

namespace App\Models\Product\Inventory\Inward;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStockInwardReturn extends Model
{
    //use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'product_stock_inward_returns';

    protected $fillable = [
        'amount',
    ];

    public function sourceable(){return $this->morphTo();} //where it is coming from
    public function product_stock_inwards(){ return $this->belongsTo(ProductStockInward::class,'product_stock_inward_id'); }

}

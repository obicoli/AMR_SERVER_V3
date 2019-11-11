<?php

namespace App\Models\Product\Inventory;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStockMovement extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'product_stock_movements';

    protected $fillable =  [
        'movement_direction',
        'quantity',
        'unit_cost',
        'total_cost',
        'batch_number',
    ];

    public function owner()
    {
        return $this->morphTo();
    }

    public function product_stock(){
        return $this->belongsTo(ProductStock::class,'product_stock_id');
    }
}

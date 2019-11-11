<?php

namespace App\Models\Product\Order;

use App\Models\Product\Product;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'order_items';

    protected $fillable = [
        'quantity',
        'discount',
        'discountable',
        'taxable',
    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

}

<?php

namespace App\Models\Product\Order;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'orders';

    protected $fillable = [
        'date_order_placed',
        'date_order_paid',
        'total_order_price',
    ];

    public function order_delivery_status(){
        return $this->hasMany(OrderDeliveryStatus::class, 'order_id');
    }

    public function order_item(){
        return $this->hasMany(Order::class,'order_id');
    }

    public function orderable(){
        //owner_id
        //owner_type
        return $this->morphTo();
    }

}

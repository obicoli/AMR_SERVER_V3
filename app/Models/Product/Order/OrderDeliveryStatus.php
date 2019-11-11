<?php

namespace App\Models\Product\Order;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDeliveryStatus extends Model
{

    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'order_delivery_statuses';

    protected $fillable = [
        'name'
    ];

    public function deliver_status(){
        return $this->hasMany(OrderDelivery::class,'delivery_status_id');
    }

    public function order(){
        return $this->hasMany(Order::class,'delivery_status_id');
    }

}

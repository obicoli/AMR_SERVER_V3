<?php

namespace App\Models\Product\Order;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDelivery extends Model
{
    //this table track order movement towards the consumer
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'order_deliveries';

    protected $fillable = [
        'date_reported',
    ];

    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }

    public function order_delivery_status(){
        return $this->belongsTo(OrderDeliveryStatus::class,'delivery_status_id');
    }

}

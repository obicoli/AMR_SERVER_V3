<?php

namespace App\Models\Shipper;

use App\Models\Product\Order\Order;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipper extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $table = 'shippers';

    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }

}

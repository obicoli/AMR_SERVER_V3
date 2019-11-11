<?php

namespace App\Models\Product;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPracticePaymentMethod extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $table = "product_practice_payment_methods";
    protected $fillable = [
        'practice_id',
        'product_payment_method_id',
    ];
}

<?php

namespace App\Models\Product;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPrice extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'product_prices';

    protected $fillable = [
        'date_from',
        'product_price',
        'product_id',
    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}

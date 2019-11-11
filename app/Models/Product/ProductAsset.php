<?php

namespace App\Models\Product;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAsset extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'product_assets';

    protected $fillable = [

    ];
}

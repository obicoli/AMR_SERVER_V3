<?php

namespace App\Models\Product;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTypeCategory extends Model
{
    use Accountable, UuidTrait, SoftDeletes;
    protected $table = "product_type_categories";

    protected $fillable = [
        'uuid',
        'product_type_id',
        'product_category_id',
    ];
}

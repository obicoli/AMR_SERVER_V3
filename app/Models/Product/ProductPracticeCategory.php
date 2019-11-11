<?php

namespace App\Models\Product;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;

class ProductPracticeCategory extends Model
{
    use UuidTrait, Accountable;

    protected $table = "product_practice_categories";

    protected $fillable = [
        'practice_id',
        'product_category_id',
        'uuid',
        'status',
        'description',
    ];
}

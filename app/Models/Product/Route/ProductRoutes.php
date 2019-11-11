<?php

namespace App\Models\Product\Route;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRoutes extends Model
{
    use Accountable, UuidTrait, SoftDeletes;
    protected $table = "product_administration_routes";

    protected $fillable = [
        'name',
        'description',
        'practice_id',
    ];
}

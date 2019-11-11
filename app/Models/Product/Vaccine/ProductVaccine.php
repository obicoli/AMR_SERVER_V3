<?php

namespace App\Models\Product\Vaccine;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVaccine extends Model
{
    use Accountable, UuidTrait, SoftDeletes;
    protected $table = "product_vaccines";

    protected $fillable = [
        'name',
        'description',
    ];
}

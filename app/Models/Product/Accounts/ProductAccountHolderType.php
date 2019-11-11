<?php

namespace App\Models\Product\Accounts;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAccountHolderType extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $table = "product_account_holder_types";
    protected $fillable = [
        'name',
        'slug',
        'description'
    ];
}

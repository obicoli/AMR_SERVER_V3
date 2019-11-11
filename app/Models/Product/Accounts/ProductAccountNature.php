<?php

namespace App\Models\Product\Accounts;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAccountNature extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = "product_account_natures";

    protected $fillable = [
        'name',
    ];
}

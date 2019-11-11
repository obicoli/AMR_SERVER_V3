<?php

namespace App\Models\Product;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBankBranch extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $table = "product_bank_branches";
    protected $fillable = [
        'product_bank_id',
        'short_code',
        'branch_code',
        'branch_name',
    ];
}

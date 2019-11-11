<?php

namespace App\Models\Product;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPracticeBank extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = "product_practice_banks";

    protected $fillable = [
        'practice_id',
        'product_bank_id',
        'product_bank_branch_id',
        'account_number',
        'account_name',
    ];
}

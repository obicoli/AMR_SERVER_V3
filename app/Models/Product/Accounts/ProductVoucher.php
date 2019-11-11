<?php

namespace App\Models\Product\Accounts;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVoucher extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = "product_vouchers";

    protected $fillable = [
        'description',
        'balance',
        'trans_type',
        'credited_account',
        'debited_account',
        'v_date',
        'auth_by',
        'practice_id',
    ];
}

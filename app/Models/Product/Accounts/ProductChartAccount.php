<?php

namespace App\Models\Product\Accounts;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductChartAccount extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    const CREDITED_ACCOUNT = "credited_account";
    const DEBITED_ACCOUNT = "debited_account";

    protected $table = "product_chart_accounts";

    protected $fillable = [
        'name',
        'description',
        'account_number',
        'account_detail_type_id',
        'account_type_id',
    ];

    public function debited(){ return $this->hasMany(ProductVoucher::class,'debited_account','account_number'); }
    public function credited(){ return $this->hasMany(ProductVoucher::class,'credited_account','account_number'); }
}

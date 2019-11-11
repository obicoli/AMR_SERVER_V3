<?php

namespace App\Models\Product\Accounts;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAccountDetailType extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    const OPENING_BALANCE_EQUITY = "Opening Balance Equity";
    protected $table = "product_account_detail_types";
    protected $fillable = [
        'name',
        'description',
    ];
    public function detail_type(){ return $this->belongsToMany(ProductAccountType::class,'product_account_type_detail_types','product_account_detail_type_id','product_account_type_id'); }
}

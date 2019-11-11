<?php

namespace App;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PractProdSaleCharge extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = "pract_prod_sale_charges";

    protected $fillable = [
        'practice_product_item_id',
        'product_sales_charge_id',
    ];
}

<?php

namespace App\Models\Product\Sales;

use App\Models\Practice\PracticeProductItem;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSaleItem extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $table = "product_sale_items";
    protected $fillable = [
        'practice_id',
        'practice_product_item_id',
        'product_sale_id',
        'item_weight',
        'qty_sold',
        'price_per_item',
        'gross_total',
        'tax_total',
        'other_sale_charge_total',
        'disc_allowed',
        'net_total',
        'batch_number',
    ];

    public function product_sale(){ return $this->belongsTo(ProductSales::class,'product_sale_id'); }
    public function practice_product_item(){ return $this->belongsTo(PracticeProductItem::class,'practice_product_item_id'); }
}

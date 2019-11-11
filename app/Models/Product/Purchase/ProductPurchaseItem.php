<?php

namespace App\Models\Product\Purchase;

use App\Models\Practice\PracticeProductItem;
use App\Models\Product\Sales\ProductPriceRecord;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPurchaseItem extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $table = "product_purchase_items";
    protected $fillable = [
        'product_item_id',
        'product_purchase_id',
        'practice_product_item_id',
        'product_price_id',
        'batch_number',
        'man_month',
        'man_year',
        'exp_month',
        'exp_year',
        'qty',
        'status',
    ];

    public function practice_product_item(){ return $this->belongsTo(PracticeProductItem::class,'practice_product_item_id'); }
    public function product_purchase(){ return $this->belongsTo(ProductPurchase::class,'product_purchase_id'); }
    public function prices(){ return $this->belongsTo(ProductPriceRecord::class,'product_price_id'); }

}

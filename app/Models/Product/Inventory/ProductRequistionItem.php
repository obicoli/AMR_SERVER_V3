<?php

namespace App\Models\Product\Inventory;

use App\Models\Practice\PracticeProductItem;
use App\Models\Product\Sales\ProductPriceRecord;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRequistionItem extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'product_requistion_items';

    protected $fillable = [
        'amount',
        'amount_approved'
    ];

    public function product_requisitions(){ return $this->belongsTo(ProductRequistion::class,'product_requistion_id'); }
    public function product_items(){ return $this->belongsTo(PracticeProductItem::class,'product_item_id'); }
    public function prices(){ return $this->belongsTo(ProductPriceRecord::class,'product_item_id'); }
}

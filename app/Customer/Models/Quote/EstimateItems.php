<?php

namespace App\Customer\Models\Quote;

use App\Models\Module\Module;
use App\Models\Product\ProductItem;
use App\Models\Product\ProductTaxation;
use App\Models\Product\Sales\ProductPriceRecord;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstimateItems extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "estimate_items";
    protected $fillable = [
        'product_item_id',
        'qty',
        'estimate_id',
        'discount_allowed',
        'product_price_id'
    ];
    public function prices(){ return $this->belongsTo(ProductPriceRecord::class,'product_price_id'); }
    public function estimates(){ return $this->belongsTo(Estimate::class,'estimate_id'); }
    public function product_items(){ return $this->belongsTo(ProductItem::class,'product_item_id'); }
    public function taxations(){ return $this->belongsToMany(ProductTaxation::class,'estimate_item_taxations','estimate_item_id','product_taxation_id'); }
}

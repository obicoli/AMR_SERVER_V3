<?php

namespace App\Models\Product;

use App\Customer\Models\Quote\EstimateItems;
use App\Models\Module\Module;
use App\Supplier\Models\PurchaseOrderItem;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTaxation extends Model
{

    use SoftDeletes, UuidTrait, Accountable;
    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;
    protected $table = "product_taxations";
    protected $fillable = [
        'collected_on_purchase',
        'collected_on_sales',
        'agent_name',
        'name',
        'registration_number',
        'description',
        'start_period',
        'filling_frequency',
        'reporting_method',
        'purchase_rate',
        'sales_rate',
        'amount',
        'status',
    ];
    //
    public function product_items(){ return $this->belongsToMany(ProductItem::class,'product_item_taxations','product_taxation_id','product_item_id'); }
    public function estimate_items(){ return $this->belongsToMany(EstimateItems::class,'estimate_item_taxations','product_taxation_id','estimate_item_id'); }
    public function po_items(){ return $this->belongsToMany(PurchaseOrderItem::class,'po_item_taxations','product_taxation_id','po_item_id'); }

}

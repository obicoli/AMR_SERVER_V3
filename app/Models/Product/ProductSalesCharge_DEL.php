<?php

namespace App\Models\Product;

use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeProductItem;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSalesCharge extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;

    protected $table = 'product_sales_charges';

    protected $fillable = [
        'name',
        'agent_name',
        'registration_number',
        'description',
        'start_period',
        'filling_frequency',
        'reporting_method',
        'collected_on_sales',
        'sales_rate',
        'purchase_rate',
        'collected_on_purchase',
        'amount',
        'status',
    ];

    public function owner()
    {
        return $this->morphTo();
    }
    //public function practice(){ return $this->belongsTo(Practice::class,'practice_id'); }
    public function practice_product_item(){ return $this->belongsToMany(PracticeProductItem::class,'pract_prod_sale_charges','product_sales_charge_id','practice_product_item_id'); }
}

<?php

namespace App\Customer\Models\Credits;

use App\Customer\Models\Invoice\CustomerRetainerInvoiceItem;
use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerRetainerTaxation extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_retainer_taxations";
    protected $fillable = [
        'retainer_item_id',
        'product_taxation_id',
        'sales_rate',
        'purchase_rate',
        'collected_on_sales',
        'collected_on_purchase',
    ];
    public function retainerItems(){ return $this->belongsTo(CustomerRetainerInvoiceItem::class,'retainer_item_id','id'); }
}

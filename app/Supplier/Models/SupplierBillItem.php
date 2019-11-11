<?php

namespace App\Supplier\Models;

use App\Models\Account\Account;
use App\Models\Module\Module;
use App\Models\Product\ProductItem;
use App\Models\Product\Sales\ProductPriceRecord;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierBillItem extends Model
{
    use SoftDeletes, UuidTrait;
    protected $connection = Module::MYSQL_SUPPLIERS_DB_CONN;
    protected $table = "supplier_bill_items";
    protected $account_type = Account::AC_SUPPLIERS;
    protected $fillable = [
        'supplier_bill_id',
        'qty',
        'description',
        'product_price_id',
        'product_item_id',
    ];

    public function supplier_bills(){ return $this->belongsTo(SupplierBill::class,'supplier_bill_id'); }
    public function product_items(){ return $this->belongsTo(ProductItem::class,'product_item_id'); }
    public function prices(){ return $this->belongsTo(ProductPriceRecord::class,'product_price_id'); }
    
}

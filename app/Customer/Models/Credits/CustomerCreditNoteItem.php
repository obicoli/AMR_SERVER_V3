<?php

namespace App\Customer\Models\Credits;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product\ProductItem;
use App\Models\Product\ProductTaxation;
use App\Models\Product\Sales\ProductPriceRecord;

class CustomerCreditNoteItem extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_credit_note_items";
    protected $fillable = [
        'credit_note_id',
        'product_item_id',
        'qty',
        'discount_allowed',
        'product_price_id'
    ];
    public function itemTaxed(){ return $this->hasMany(CustomerCreditNoteTaxation::class,'credit_note_item_id','id'); }
    public function prices(){ return $this->belongsTo(ProductPriceRecord::class,'product_price_id','id'); }
    public function product_items(){ return $this->belongsTo(ProductItem::class,'product_item_id','id'); }
    public function taxations(){ return $this->belongsToMany(ProductTaxation::class,'customer_credit_note_taxations','credit_note_item_id','product_taxation_id'); }
    public function creditNotes(){ return $this->belongsTo(CustomerCreditNote::class,'credit_note_id','id'); }
}

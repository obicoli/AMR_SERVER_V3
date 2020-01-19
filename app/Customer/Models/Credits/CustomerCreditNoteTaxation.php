<?php

namespace App\Customer\Models\Credits;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerCreditNoteTaxation extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_credit_note_taxations";
    protected $fillable = [
        'credit_note_item_id',
        'product_taxation_id',
        'sales_rate',
        'purchase_rate',
        'collected_on_sales',
        'collected_on_purchase',
    ];
    public function credit_note_items(){ return $this->belongsTo(CustomerCreditNoteItem::class,'credit_note_item_id','id'); }
}

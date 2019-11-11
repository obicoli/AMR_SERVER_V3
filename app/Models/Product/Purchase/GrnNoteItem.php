<?php

namespace App\Models\Product\Purchase;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Account\Vendors\AccountVendor;
use App\Models\Practice\PracticeProductItem;

class GrnNoteItem extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $table = "grn_note_items";
    protected $fillable = [
        'comment',
        'amount'
    ];
    //owner
    public function owner(){ return $this->morphTo();} //Owner can be ProductPoItems, etc
    public function grn_note(){ return $this->belongsTo(GrnNote::class,'grn_note_id'); }
    public function product_items(){ return $this->belongsTo(PracticeProductItem::class,'product_item_id');}
}

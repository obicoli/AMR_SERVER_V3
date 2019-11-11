<?php

namespace App\Models\Product\Purchase;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Account\Vendors\AccountVendor;
use App\Models\NotificationCenter\Inventory\NotificationInventoryMailAttach;
use App\Models\Practice\Department;
use App\Models\Product\Store\ProductStore;

class GrnNote extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $table = "grn_notes";
    protected $fillable = [
        'advise_note',
        'accounts_copy',
        'supplier_copy',
        'store_copy',
        'date_received',
        'transaction_type'
    ];
    public function receivedby(){ return $this->morphTo(); }
    public function checkedby(){ return $this->morphTo(); }
    public function deliverylocation(){ return $this->morphTo(); }
    public function departments(){ return $this->belongsTo(Department::class,'department_id'); }
    public function stores(){ return $this->belongsTo(ProductStore::class,'store_id'); }
    public function substores(){ return $this->belongsTo(ProductStore::class,'sub_store_id'); }

    public function transactionable(){ return $this->morphTo(); }//transaction we are receiving Goods from e.g PO, Purchases
    public function grn_items(){ return $this->hasMany(GrnNoteItem::class,'grn_note_id'); }
    public function mails_attachments(){ return $this->morphMany(NotificationInventoryMailAttach::class,'attachable','attachable_type','attachable_id'); }
    // public function owner(){ return $this->morphTo();} //Enterprise owning this PO
    // public function grn_items(){ return $this->hasMany(GrnNoteItem::class,'grn_id'); }
}

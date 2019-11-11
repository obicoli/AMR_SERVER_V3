<?php

namespace App\Models\Product\Purchase;

use App\Models\Practice\Practice;
use App\Models\Practice\PracticeProductItem;
use App\Models\Product\ProductPaymentMethod;
use App\Models\Supplier\Supplier;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Account\Payments\AccountPaymentTransaction;
use App\Models\Account\Payments\AccountPaymentType;
use App\Models\Account\Vendors\AccountVendor;

class ProductPurchase extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $table = "product_purchases";
    protected $fillable = [
        'supplier_id',
        //'department_id',
        'payment_type_id',
        'purchase_method',
        'store_id',
        'sub_store_id',
        'bill_no',
        'discount_offered',
        'note',
        'status',
        'payment_date',
        'owner_type',
        'owner_id',
    ];

    public function owner(){ return $this->morphTo();}
    public function owning(){ return $this->morphTo();}

    //public function payments(){ return $this->hasMany(ProductPurchasePayment::class,'product_purchase_id'); }
    public function items(){ return $this->hasMany(ProductPurchaseItem::class,'product_purchase_id'); }
    public function practices(){ return $this->belongsTo(Practice::class,'practice_id'); }
    //public function payment_method(){ return $this->belongsTo(ProductPaymentMethod::class,'payment_method_id'); }
    public function payment_types(){ return $this->belongsTo(AccountPaymentType::class,'payment_type_id'); }
    //public function suppliers(){ return $this->belongsTo(Supplier::class,'supplier_id'); }
    public function suppliers(){ return $this->belongsTo(AccountVendor::class,'supplier_id'); }
    public function payments(){ return $this->morphMany(AccountPaymentTransaction::class,'transactionable','transactionable_type','transactionable_id'); }

}

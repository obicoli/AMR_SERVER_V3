<?php

namespace App\Customer\Models;

use App\Accounting\Models\COA\AccountsHolder;
use App\Accounting\Models\Payments\AccountPaymentType;
use App\Customer\Models\Quote\Estimate;
use App\Models\Module\Module;
use App\Supplier\Models\PurchaseOrder;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customers";

    protected $fillable = [
        'vendor_type',
        'city',
        'notes',
        'status',
        'first_name',
        'other_name',
        'middle_name',
        'company',
        'postal_code',
        'country',
        'email',
        'mobile',
        'phone',
        'fax',
        'longitude',
        'latitude',
        'address',
        'prefered_payment_id',
        'customer_terms_id',
        'business_id',
        'title'
    ];

    public function owning(){ return $this->morphTo();} //Branch level
    public function customer_terms(){ return $this->belongsTo(CustomerTerms::class,'customer_terms_id'); }
    public function prefered_payment(){ return $this->belongsTo(AccountPaymentType::class,'prefered_payment_id'); }
    public function account_holders(){ return $this->morphMany(AccountsHolder::class, 'owner','owner_type','owner_id'); }
    public function estimates(){ return $this->morphMany(Estimate::class, 'customer','customer_type','customer_id'); }
    public function purchase_order_shipping(){ return $this->morphMany(PurchaseOrder::class,'shipable','shipable_type','shipable_id'); }

}

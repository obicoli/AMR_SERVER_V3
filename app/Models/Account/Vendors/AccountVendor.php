<?php

namespace App\Models\Account\Vendors;

use App\Models\Account\Account;
use App\Models\Product\ProductItem;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product\Purchase\ProductPurchase;
use App\Traits\AccountableTrait;

class AccountVendor extends Model
{
    use SoftDeletes, Accountable,UuidTrait,AccountableTrait;

    protected $table = "account_vendors";

    protected $account_type = Account::AC_SUPPLIERS;

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
        'terms',
        'bill_rate',
        'business_id',
        'longitude',
        'latitude',
        'address',
    ];

    public function owner()
    {
        return $this->morphTo();
    }

    public function owning()
    {
        return $this->morphTo();
    }

    public function purchases(){ return $this->hasMany(ProductPurchase::class,'supplier_id'); }
    public function product_items(){ return $this->hasMany(ProductItem::class,'prefered_supplier_id'); }
    
    public function getAccountType()
    {
        // TODO: Implement getAccountType() method.
        return $this->account_type;
    }

    public function getAccountId()
    {
        // TODO: Implement getAccountId() method.
        return $this->id;
    }

    public function getAccountName()
    {
        // TODO: Implement getAccountName() method.
        return $this->name;
    }

    public function getOrCreate($id, array $data)
    {
        $sup = self::query()->where("id", $id)->firstOrFail();
        if (!$sup) {
            $sup = self::query()->create($data);

            return $sup;
        }
        return $sup;
    }
    
}

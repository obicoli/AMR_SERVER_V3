<?php

namespace App\Models\Pharmacy;

use App\Models\Practice\Inventory\PracticeAccountHolder;
use App\Models\Practice\Practice;
use App\Models\Product\Order\Order;
use App\Models\Users\User;
use App\Traits\AccountableTrait;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Account\Account;
use App\Models\Wholesaler\Wholesaler;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Practice\Department;

class Pharmacy extends Model
{

    use SoftDeletes, UuidTrait, AccountableTrait, Accountable;

    //protected $id_column = "id";
    protected $table = "pharmacies";
    protected $guarded = [
        'id'
    ];
    protected $account_type = Account::AC_PHARMACY;
    const USER_TYPE = "Pharmacy";
    const DEFAULT_AVATAR = "/assets/images/profile/avatar.jpg";
    const OWNER_TYPE = "App\Models\Pharmacy\Pharmacy";

    public function practices(){return $this->morphMany(Practice::class,'owner','owner_type','owner_id');}
    public function departments(){return $this->morphMany(Department::class,'owner','owner_type','owner_id');}
    //public function practice_account_holder(){ return $this->morphMany(PracticeAccountHolder::class, 'owner','owner_type','owner_id'); }

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

    public function wholesalers()
    {
        return $this->hasMany(Wholesaler::class, "supplier_id", "id");
    }

    public function supplier()
    {
        return $this->belongsTo(Manufacturer::class, "manufacturer_id", "id");
    }

    public function orders(){
        return $this->morphMany(Order::class,'orderable','owner_type','owner_id','id');
    }

    public function user(){ return $this->belongsTo(User::class,'user_id'); }

}

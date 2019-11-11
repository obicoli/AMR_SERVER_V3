<?php

namespace App\Models\Wholesaler;

use App\Models\Practice\Inventory\PracticeAccountHolder;
use App\Traits\AccountableTrait;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Account\Account;
use App\Models\Supplier\Supplier;

class Wholesaler extends Model
{
    use SoftDeletes, UuidTrait, AccountableTrait, Accountable;

    protected $id_column = "id";
    protected $account_type = Account::AC_WHOLESALERS;
    protected $guarded = [];

    public function practice_account_holder(){ return $this->morphMany(PracticeAccountHolder::class, 'owner','owner_type','owner_id'); }

    public function getAccountType()
    {
        return $this->account_type;
    }

    public function getAccountId()
    {
        return $this->id_column;
    }

    public function getAccountName()
    {
        return $this->name;
    }

    /**
     * Added an initial fix to the get or create service
     *
     * @param $uuid
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Builder|Model
     */
    public static function getOrCreate($uuid, array $data)
    {
        $ws = self::query()->where("uuid", $uuid)->firstOrFail();

        if (!$ws) {
            $ws = self::query()->create($data);
            return $ws;
        }

        return $ws;
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, "supplier_id", "id");
    }

}

<?php

namespace App\Models\Account\Customer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ByTestGear\Accountable\Traits\Accountable;
use App\Traits\UuidTrait;
use App\Contracts\AccountableInterface;
use App\Traits\AccountableTrait;
use App\Models\Account\Account;

class Customer extends Model implements AccountableInterface
{
    use SoftDeletes,Accountable,UuidTrait,AccountableTrait;

    protected $table = "customers";

    protected $fillable = [];

    protected $guarded = ['id'];

    protected $account_type = Account::AC_CUSTOMERS;

    public function getAccountName()
    {
        return $this->phone;
    }

    public function getAccountId()
    {
        return $this->id;
    }

    public function getAccountType()
    {
        return $this->account_type;
    }

}

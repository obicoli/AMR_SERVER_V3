<?php

namespace App\Finance\Models\Banks;

use App\Models\Module\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;

class AccountBankAccountType extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_FINANCE_DB_CONN;
    protected $table = "account_bank_account_types";
    protected $fillable = [
        'name',
    ];
}

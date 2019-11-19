<?php

namespace App\Accounting\Models;

use App\Accounting\Models\COA\AccountsHolder;
use App\Accounting\Models\Voucher\AccountsSupport;
use App\Models\Module\Module;
use App\Traits\UuidTrait;
use Carbon\Carbon;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountHolder extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    const AC_SUSPENSE = "SUSPENSE";
    const AC_USER = "USER";
    const AC_HOSPITAL = "HOSPITAL";
    const AC_PRACTICE = "PRACTICE";
    const AC_PHARMACY = "PHARMACY";
    const AC_DOCTOR = "DOCTOR";
    const AC_PATIENT = "PATIENT";
    const AC_MANUFACTURES = "Manufacturer";
    const AC_SUPPLIERS = "Supplier";
    const AC_WHOLESALERS = "Wholesaler";
    const AC_CUSTOMERS = "Customer";
    const AC_EMPLOYEE = "Employee";

    protected $connection = Module::MYSQL_ACCOUNTING_DB_CONN;
    
    protected $table = "account_holders";

    protected $fillable = [
        "name", "bonus", "main", "balance"
    ];
    public function owner(){ return $this->morphTo();}
    public function support_documents(){ return $this->hasMany(AccountsSupport::class,'account_number','account_number'); }

}

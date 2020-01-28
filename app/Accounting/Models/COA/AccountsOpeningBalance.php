<?php

namespace App\Accounting\Models\COA;

use App\Accounting\Models\Voucher\AccountsSupport;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Finance\Models\Banks\AccountsBank;
use App\Finance\Models\Banks\BankTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Support\Facades\Log;
use App\Models\Module\Module;
use App\Models\Product\ProductTaxation;

class AccountsOpeningBalance extends Model
{
    //Accounting-Company Integration Model
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_ACCOUNTING_DB_CONN;
    protected $table = "accounts_opening_balances";
    protected $fillable = [
        'amount',
        'status',
    ];
    public function accountable()
    {
        return $this->morphTo();
    }
    public function double_entry_support_document(){
        return $this->morphMany(AccountsSupport::class,'transactionable','transactionable_type','transactionable_id');
    }
}

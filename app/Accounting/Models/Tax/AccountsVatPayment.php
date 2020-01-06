<?php

namespace App\Accounting\Models\Tax;

use App\Accounting\Models\Voucher\AccountsSupport;
use App\Finance\Models\Banks\BankTransaction;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Module\Module;

class AccountsVatPayment extends Model
{
    use SoftDeletes,Accountable,UuidTrait;
    protected $connection = Module::MYSQL_ACCOUNTING_DB_CONN;
    protected $table = "accounts_vat_payments";
    protected $fillable = [
        'vat_return_id',
        'bank_account_id',
        'amount',
        'type',
        'trans_date',
        'notes',
        'reference_number'
    ];
    public function bank_transactions(){ return $this->morphMany(BankTransaction::class,'transactionable','transactionable_type','transactionable_id'); }
    public function double_entry_support_document(){
        return $this->morphMany(AccountsSupport::class,'transactionable','transactionable_type','transactionable_id');
    }
}

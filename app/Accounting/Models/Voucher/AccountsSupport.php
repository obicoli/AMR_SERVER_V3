<?php

namespace App\Accounting\Models\Voucher;

use App\Accounting\Models\AccountHolder;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Module\Module;

class AccountsSupport extends Model
{
    use SoftDeletes, Accountable,UuidTrait;
    protected $connection = Module::MYSQL_ACCOUNTING_DB_CONN;
    protected $table = "accounts_supports";
    protected $fillable = [
        'trans_type',
        'trans_name',
        'voucher_id',
        'account_number',
        'reference_number'
    ];

    public function transactionable(){ 
        /*
            This transactions involves:
            Bank Transaction, Invoices
            Supplier: If Transaction type is Supplier Opening Balance
            Customer: If Transaction type is Customer Opening Balance
            Account: If Transaction type is Account Opening Balance
            Bills: If Transaction type is Supplier Bill
        */
        return $this->morphTo();
    }
    public function vouchers(){ return $this->belongsTo(AccountsVoucher::class,'voucher_id'); }
    public function account_holders(){ return $this->belongsTo(AccountHolder::class,'account_number','account_number'); }

    //To be deleted
    public function accounts_vouchers()
    {
        return $this->belongsToMany(AccountsVoucher::class,'accounts_voucher_supports','support_id','voucher_id');
    }

    public function journalEntries()
    {
        return $this->belongsToMany(AccountsVoucher::class,'accounts_voucher_supports','support_id','voucher_id');
    }

}

<?php

namespace App\Accounting\Models\Voucher;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Account\Coa\AccountChartAccount;
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
    ];
    
    public function vouchers(){ return $this->belongsTo(AccountsVoucher::class,'voucher_id'); }

}

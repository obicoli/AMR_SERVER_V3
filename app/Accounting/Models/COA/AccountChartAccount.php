<?php

namespace App\Accounting\Models\COA;

use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Finance\Models\Banks\AccountsBank;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Support\Facades\Log;
use App\Models\Module\Module;

class AccountChartAccount extends Model
{
    //Accounting-Company Integration Model
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_ACCOUNTING_DB_CONN;
    protected $table = "account_chart_accounts";
    protected $fillable = [
        'name',
        'code',
        'accounts_type_id',
        'default_coa_id',
        'coa_id',
        'notes',
        'is_sub_account',
        'default_code',
        'is_special'
    ];
    public function owning(){ return $this->morphTo();} //Branch level
    public function coas(){ return $this->belongsTo(AccountsCoa::class,'default_coa_id'); }
    public function account_types(){ return $this->belongsTo(AccountsType::class,'accounts_type_id'); }
    public function accounts_natures(){ return $this->belongsTo(AccountsNature::class,'accounts_nature_id'); }

    public function credited_vouchers(){ return $this->hasMany(AccountsVoucher::class,'credited','code'); }
    public function debited_vouchers(){ return $this->hasMany(AccountsVoucher::class,'debited','code'); }
    public function bank_accounts(){ return $this->hasMany(AccountsBank::class,'ledger_account_id','id'); }

}

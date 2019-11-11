<?php

namespace App\Accounting\Models\Voucher;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Module\Module;

class AccountsVoucher extends Model
{
    use SoftDeletes, Accountable,UuidTrait;
    protected $connection = Module::MYSQL_ACCOUNTING_DB_CONN;
    protected $table = "accounts_vouchers";
    protected $fillable = [
        'amount',
        'notes',
        'voucher_date',
        'credited',
        'debited',
        'transaction_id',
        'credited_parent',
        'debited_parent'
    ];

    public function support_documents(){ return $this->hasMany(AccountsSupport::class,'voucher_id'); }
    public function owner(){return $this->morphTo();}
    public function credited(){return $this->belongsTo(AccountChartAccount::class,'credited','code');}
    public function debited(){return $this->belongsTo(AccountChartAccount::class,'debited','code');}


}

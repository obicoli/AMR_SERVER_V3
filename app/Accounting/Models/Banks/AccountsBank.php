<?php

namespace App\Accounting\Models\Banks;

use App\Models\Module\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;

class AccountsBank extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_ACCOUNTING_DB_CONN;
    protected $table = "accounts_banks";
    protected $fillable = [
        'account_name',
        'account_number',
        'balance',
        'status',
        'account_type_id',
        'bank_id',
        'branch_id'
    ];

    public function owner(){ return $this->morphTo();}

    public function bank(){ return $this->belongsTo(AccountMasterBank::class,'bank_id');}

    public function bank_branch(){ return $this->belongsTo(AccountMasterBankBranch::class,'branch_id');}

    public function account_types(){ return $this->belongsTo(AccountBankAccountType::class,'account_type_id'); }

}

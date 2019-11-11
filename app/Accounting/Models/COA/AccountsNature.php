<?php

namespace App\Accounting\Models\COA;

use App\Models\Module\Module;
use Illuminate\Database\Eloquent\Model;

class AccountsNature extends Model
{

    protected $connection = Module::MYSQL_ACCOUNTING_DB_CONN;
    protected $table = "accounts_natures";
    protected $fillable = [
        'name',
    ];
    public function accounts_coas(){ return $this->hasMany(AccountsCoa::class,'accounts_nature_id'); }
    public function account_types(){ return $this->hasMany(AccountsType::class,'accounts_nature_id'); }

}

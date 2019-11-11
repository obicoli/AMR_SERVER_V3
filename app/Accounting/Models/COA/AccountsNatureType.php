<?php

namespace App\Accounting\Models\COA;

use App\Models\Module\Module;
use Illuminate\Database\Eloquent\Model;

class AccountsNatureType extends Model
{
    protected $connection = Module::MYSQL_ACCOUNTING_DB_CONN;
    protected $table = "accounts_nature_types";
    protected $fillable = [
        'name',
    ];
}

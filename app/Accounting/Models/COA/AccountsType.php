<?php

namespace App\Accounting\Models\COA;

use App\Models\Module\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;

class AccountsType extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_ACCOUNTING_DB_CONN;
    protected $table = "accounts_types";
    protected $fillable = [
        'name',
        'accounts_nature_id',
        'accounts_nature_type_id',
    ];
    
    public function accounts(){ return $this->hasMany(AccountChartAccount::class,'accounts_type_id'); }
    public function default_accounts(){ return $this->hasMany(AccountsCoa::class,'accounts_type_id'); }
    public function accounts_nature_types(){ return $this->belongsTo(AccountsNatureType::class,'accounts_nature_type_id'); }
    public function accounts_natures(){ return $this->belongsTo(AccountsNature::class,'accounts_nature_id'); }

}

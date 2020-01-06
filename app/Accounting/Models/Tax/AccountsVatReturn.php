<?php

namespace App\Accounting\Models\Tax;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Module\Module;

class AccountsVatReturn extends Model
{
    use SoftDeletes,Accountable,UuidTrait;
    protected $connection = Module::MYSQL_ACCOUNTING_DB_CONN;
    protected $table = "accounts_tax_returns";
    protected $fillable = [
        'status',
        'reference_number',
        'period_start_date',
        'period_due_date',
        'frequency',
        'vat_pin'
    ];
    public function taxReturnItems(){ return $this->hasMany(AccountsTaxReturnItem::class,'tax_return_id','id'); }
    public function owning()
    {
        return $this->morphTo();
    }
}

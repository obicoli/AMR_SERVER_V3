<?php

namespace App\Accounting\Models\Tax;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Module\Module;
use App\Models\Practice\PracticeTaxation;

class AccountsTaxation extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_ACCOUNTING_DB_CONN;
    protected $table = "accounts_taxations";
    protected $fillable = [
        'collected_on_purchase',
        'collected_on_sales',
        'agent_name',
        'name',
        'registration_number',
        'description',
        'start_period',
        'filling_frequency',
        'reporting_method',
        'purchase_rate',
        'sales_rate',
        'amount',
        'status',
    ];
    public function practice_taxation(){ return $this->hasMany(PracticeTaxation::class,'accounts_taxation_id','id'); }
}

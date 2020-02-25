<?php

namespace App\Models\Practice\Settings;

use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ByTestGear\Accountable\Traits\Accountable;

class PracticeFinancialSetting extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_DB_CONN;
    protected $table = "practice_financial_settings";
    protected $fillable = [
        'practice_id',
        'financial_year_start',
        'financial_year_end',
        'current_accounting_period',
    ];

    public function getUuid(){ return $this->uuid; }
    public function getFinancialYearStart(){ return $this->financial_year_start; }
    public function getFinancialYearEnd(){ return $this->financial_year_end; }
    public function getCurrentAccountingPeriod(){ return $this->current_accounting_period; }

    public function practices(){ return $this->belongsTo(Practice::class,'practice_id','id'); }
}

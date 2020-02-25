<?php

namespace App\Models\Practice\Settings;

use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ByTestGear\Accountable\Traits\Accountable;

class PracticeGeneralSettings extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_DB_CONN;
    protected $table = "practice_general_settings";
    protected $fillable = [
        'practice_id',
        'ageing_monthly',
        'ageing_based_on',
        'rounding_type',
        'round_to_nearest',
        'qty_decimal_places',
        'value_decimal_places',
        'currency_symbol',
        'system_date_format',
    ];

    public function getId(){ return $this->id; }
    public function getUuid(){ return $this->uuid; }
    public function getAgeingMonthly(){ return $this->ageing_monthly; }
    public function getAgeingBased(){ return $this->ageing_based_on; }
    public function getRoundingType(){ return $this->rounding_type; }
    public function getRoundToNearest(){ return $this->round_to_nearest; }
    public function getQtyDecimal(){ return $this->qty_decimal_places; }
    public function getValueDecimal(){ return $this->value_decimal_places; }
    public function getCurrencySymbol(){ return $this->currency_symbol; }
    public function getSystemDateFormat(){ return $this->system_date_format; }

    public function practices(){ return $this->belongsTo(Practice::class,'practice_id','id'); }

}

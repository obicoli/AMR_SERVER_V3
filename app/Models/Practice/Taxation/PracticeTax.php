<?php

namespace App\Models\Practice\Taxation;

use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ByTestGear\Accountable\Traits\Accountable;

class PracticeTax extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_DB_CONN;
    protected $table = "practice_taxes";
    protected $fillable = [
        'obligation',
        'tax_number',
        'tax_station',
        'agent_name',
        'filling_frequency',
        'reporting_method',
    ];

    public function getId(){ return $this->id; }
    public function getUuid(){ return $this->uuid; }
    public function getObligation(){ return $this->obligation; }
    public function getTaxNumber(){ return $this->tax_number; }
    public function getTaxStation(){ return $this->tax_station; }
    public function getAgentName(){ return $this->agent_name; }
    public function getFilingFrequency(){ return $this->filling_frequency; }
    public function getReportingMethod(){ return $this->reporting_method; }

    public function owner(){ return $this->morphTo();}
    public function vatTypes(){ return $this->hasMany(PracticeTaxVat::class,'practice_taxes_id','id'); }
}

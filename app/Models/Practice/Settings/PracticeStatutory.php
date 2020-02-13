<?php

namespace App\Models\Practice\Settings;

use App\Models\Localization\Country;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ByTestGear\Accountable\Traits\Accountable;

class PracticeStatutory extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_DB_CONN;
    protected $table = "practice_statutories";
    protected $fillable = [
        'country_id',
        'region',
        'city',
        'entity_type',
        'tax_office',
        'registration_number',
        'registered_name',
        'tax_number',
    ];
    //Columns
    public function getTaxNumber(){ return $this->tax_number; }
    public function getRegion(){ return $this->region; }
    public function getCity(){ return $this->city; }
    public function getEntityType(){ return $this->entity_type; }
    public function getTaxOffice(){ return $this->tax_office; }
    public function getRegistrationNumber(){ return $this->registration_number; }
    public function getRegistrationName(){ return $this->registered_name; }
    public function getCountryId(){ return $this->country_id; }
    public function getUuid(){ return $this->uuid; }

    public function practices(){
        return $this->belongsTo(Practice::class,'practice_id','id');
    }
    public function countries(){ return $this->belongsTo(Country::class,'country_id','id'); }
}

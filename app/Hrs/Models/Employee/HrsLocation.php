<?php

namespace App\Hrs\Models\Employee;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrsLocation extends Model
{
    
    use SoftDeletes,Accountable,UuidTrait;
    
    protected $connection = Module::MYSQL_HR_DB_CONN;

    protected $table = "hrs_locations";

    protected $fillable = [
        'street_address',
        'postal_code',
        'city'
    ];

    public function countries(){ return $this->hasMany(HrsCountry::class,'country_id'); }
    public function departments(){ return $this->hasMany(HrsDepartment::class,'location_id'); }
    
}

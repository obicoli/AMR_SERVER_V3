<?php

namespace App\Hrs\Models\Employee;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrsCountry extends Model
{
    
    use SoftDeletes,Accountable,UuidTrait;

    protected $connection = Module::MYSQL_HR_DB_CONN;

    protected $table = "hrs_countries";

    protected $fillable = [
        'name',
        'code',
        'currency'
    ];

    public function regions(){ return $this->belongsTo(HrsRegion::class,'region_id'); }
    public function locations(){ return $this->hasMany(HrsLocation::class,'country_id'); }
}

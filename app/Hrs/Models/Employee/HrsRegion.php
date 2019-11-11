<?php

namespace App\Hrs\Models\Employee;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrsRegion extends Model
{
    use SoftDeletes,Accountable,UuidTrait;
    
    protected $connection = Module::MYSQL_HR_DB_CONN;

    protected $table = "hrs_regions";

    protected $fillable = [
        'name',
    ];

    public function countries(){ return $this->hasMany(HrsCountry::class,'region_id'); }
}

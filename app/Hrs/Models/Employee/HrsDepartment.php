<?php

namespace App\Hrs\Models\Employee;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrsDepartment extends Model
{
    
    use SoftDeletes,Accountable,UuidTrait;
    
    protected $connection = Module::MYSQL_HR_DB_CONN;

    protected $table = "hrs_departments";

    protected $fillable = [
        'name',
    ];

    public function job_history(){ return $this->hasMany(HrsJobHistory::class,'department_id'); }
    public function employees(){ return $this->hasMany(HrsEmployee::class,'department_id'); }
    public function managers(){ return $this->hasMany(HrsManager::class,'department_id'); }
    public function locations(){ return $this->belongsTo(HrsLocation::class,'location_id'); }

}

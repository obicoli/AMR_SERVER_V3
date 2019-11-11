<?php

namespace App\Hrs\Models\Employee;

use App\Hrs\Models\HrsEmployee;
use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrsManager extends Model
{
    
    use SoftDeletes,Accountable,UuidTrait;
    
    protected $connection = Module::MYSQL_HR_DB_CONN;

    protected $table = "hrs_managers";

    protected $fillable = [
        'status',
        'bonus'
    ];

    public function employees(){ return $this->belongsTo(HrsEmployee::class,'manager_id'); }
    public function departments(){ return $this->belongsTo(HrsDepartment::class,'department_id'); }
    
}

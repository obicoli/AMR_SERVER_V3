<?php

namespace App\Hrs\Models\Employee;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrsJobHistory extends Model
{
    use SoftDeletes,Accountable,UuidTrait;
    
    protected $connection = Module::MYSQL_HR_DB_CONN;

    protected $table = "hrs_job_histories";

    protected $fillable = [
        'start_date',
        'end_date',
    ];

    public function employees(){ return $this->belongsTo(HrsEmployee::class,'employee_id'); }
    public function jobs(){ return $this->belongsTo(HrsJob::class,'job_id'); }
    public function departments(){ return $this->belongsTo(HrsDepartment::class,'department_id'); }

}

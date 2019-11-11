<?php

namespace App\Hrs\Models\Employee;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrsJob extends Model
{
    use SoftDeletes,Accountable,UuidTrait;
    
    protected $connection = Module::MYSQL_HR_DB_CONN;

    protected $table = "hrs_jobs";

    protected $fillable = [
        'job_title',
        'max_salary',
        'min_salary'
    ];

    public function employees(){ return $this->hasMany(HrsEmployee::class,'job_id'); }
    public function job_history(){ return $this->hasMany(HrsJobHistory::class,'job_id'); }

}

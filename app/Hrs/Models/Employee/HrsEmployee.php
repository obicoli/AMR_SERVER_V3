<?php

namespace App\Hrs\Models\Employee;

use App\Models\Module\Module;
use App\Models\Product\Supply\ProductSupply;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrsEmployee extends Model
{
    use SoftDeletes,Accountable,UuidTrait;

    protected $connection = Module::MYSQL_HR_DB_CONN;

    protected $table = "hrs_employees";

    protected $fillable = [
        'commission_pct',
        'hired_date',
        'first_name',
        'last_name',
        'other_name',
        'email',
        'phone',
    ];

    public function jobs(){ return $this->belongsTo(HrsJob::class,'job_id'); }
    public function job_history(){ return $this->hasMany(HrsJobHistory::class,'employee_id'); }
    public function departments(){ return $this->belongsTo(HrsDepartment::class,'department_id'); }
    public function managers(){ return $this->hasMany(HrsManager::class,'manager_id'); }
    public function owner(){ return $this->morphTo();} //Enterprise owning this Emp
    public function owning(){ return $this->morphTo();} //Branch owning this Emp
    public function product_supply(){ return $this->hasMany(ProductSupply::class,'driver_id'); }

}

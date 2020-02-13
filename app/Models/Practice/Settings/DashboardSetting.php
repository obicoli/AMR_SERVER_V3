<?php

namespace App\Models\Practice\Settings;

use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ByTestGear\Accountable\Traits\Accountable;

class DashboardSetting extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_DB_CONN;
    protected $table = "dashboard_widgets";
    protected $fillable = [
        'name',
        'type',
        'description',
        'status'
    ];
    public function dashboard_widgets(){ return $this->belongsToMany(Practice::class,'company_widgets','widget_id','practice_id'); }
}

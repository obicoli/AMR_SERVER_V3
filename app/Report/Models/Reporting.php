<?php

namespace App\Report\Models;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reporting extends Model
{
    use UuidTrait,Accountable;
    protected $connection = Module::MYSQL_REPORTS_DB_CONN;
    protected $table = "reportings";
    protected $fillable = [
        'name',
        'section',
        'description'
    ];
}

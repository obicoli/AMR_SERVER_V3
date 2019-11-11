<?php

namespace App\Models\Practice;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;

class PracticeRole extends Model
{
    use SoftDeletes, Accountable, UuidTrait, HasRoleAndPermission;
    protected $connection = Module::MYSQL_DB_CONN;
    protected $table = "practice_roles";
    protected $fillable = [
        'practice_id',
        'name',
        'slug',
        'description',
    ];
}

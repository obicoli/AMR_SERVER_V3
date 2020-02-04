<?php

namespace App\Models\Product\Route;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRoutes extends Model
{
    use Accountable, UuidTrait, SoftDeletes;
    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;
    protected $table = "product_administration_routes";
    protected $fillable = [
        'name',
        'description',
        'status',
    ];
}

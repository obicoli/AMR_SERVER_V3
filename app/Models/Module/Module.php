<?php

namespace App\Models\Module;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes, Accountable, UuidTrait;

    const MYSQL_HR_DB_CONN = "mysql_hr";
    const MYSQL_ACCOUNTING_DB_CONN = "mysql_accounting_module";
    const MYSQL_CUSTOMER_DB_CONN = "mysql_customer_module";
    const MYSQL_ASSETS_DB_CONN = "mysql_assests";
    const MYSQL_PRODUCT_DB_CONN = "mysql";
    const MYSQL_TELEMEDICINE_DB_CONN = "mysql_telemedicine_module";
    const MYSQL_SUPPLIERS_DB_CONN = "mysql_suppliers_module";
    const MYSQL_DB_CONN = "mysql";

    protected $table = "modules";

    protected $fillable = ["name","description", "version", "documentation"];

    protected $casts = [
        "documentation" => "json"
    ];
}

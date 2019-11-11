<?php

namespace App\Models\NotificationCenter\Inventory;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryAlert extends Model
{
    use UuidTrait, SoftDeletes, Accountable;

    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;

    protected $table = 'inventory_alerts';

    protected $fillable = [
        'status',
        'message',
        'mobile',
        'resend_count',
        'name',
        'email_enabled',
        'sms_enabled',
        'email',
        'mobile',
        'message',
    ];

    public function owner(){ return $this->morphTo();}
    public function owning(){ return $this->morphTo();} //
}

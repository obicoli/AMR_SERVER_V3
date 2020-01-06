<?php

namespace App\Supplier\Models;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Accounting\Models\Voucher\AccountsSupport;
use App\Models\NotificationCenter\Inventory\NotificationInventoryMailAttach;

class SupplierCreditStatus extends Model
{
    use SoftDeletes, UuidTrait,Accountable;
    protected $connection = Module::MYSQL_SUPPLIERS_DB_CONN;
    protected $table = "supplier_credit_statuses";
    protected $fillable = [
        'status',
        'notes',
        'type',
        'supplier_credit_id'
    ];
    public function responsible(){ return $this->morphTo();}
}

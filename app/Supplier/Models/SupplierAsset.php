<?php

namespace App\Supplier\Models;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierAsset extends Model
{
    use UuidTrait, SoftDeletes, Accountable;
    protected $connection = Module::MYSQL_SUPPLIERS_DB_CONN;
    protected $table = "supplier_assets";
    protected $fillable = [
        'file_path',
        'file_mime',
        'file_name',
        'file_size',
        'asset_type',
    ];
    public function owner(){
        return $this->morphTo();
    }
}

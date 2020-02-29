<?php

namespace App\Models\Product;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAsset extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;
    protected $table = 'product_assets';
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

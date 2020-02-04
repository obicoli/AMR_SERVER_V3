<?php

namespace App\Models\Product;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGeneric extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;
    protected $table = "product_generics";
    protected $fillable = [
        'name',
        'status',
        'description',
        'owner_type',
        'owner_id'
    ];
    public function owner(){ return $this->morphTo();}
}

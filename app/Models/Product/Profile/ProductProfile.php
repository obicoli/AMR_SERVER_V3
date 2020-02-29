<?php

namespace App\Models\Product\Profile;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductProfile extends Model
{
    use Accountable, UuidTrait, SoftDeletes;
    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;
    protected $table = "product_profiles";
    protected $fillable = [
        'name',
        'description',
        'status'
    ];
    public function owner(){ return $this->morphTo();}
}

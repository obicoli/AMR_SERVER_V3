<?php

namespace App\Models\Product;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $table = 'features';

    public function product(){
        return $this->belongsToMany(Product::class,'products_features','feature_id','product_id');
    }
}

<?php

namespace App\Models\Product;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Precaution extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'precautions';

    protected $fillable = ['description'];

    public function product(){
        return $this->belongsToMany(Product::class,'product_precaution','precaution_id','product_id');
    }

}

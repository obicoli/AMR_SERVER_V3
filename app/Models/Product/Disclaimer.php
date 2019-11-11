<?php

namespace App\Models\Product;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disclaimer extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'disclaimers';

    protected $fillable = [
        'description'
    ];

    public function product(){
        return $this->belongsToMany(Product::class, 'products_disclaimers','disclaimer_id','product_id');
    }

}

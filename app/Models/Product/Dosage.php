<?php

namespace App\Models\Product;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dosage extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'dosages';

    protected $fillable = [
        'description'
    ];

    public function product(){
        return $this->belongsToMany(Product::class, 'product_dosage','dosage_id','product_id');
    }
}

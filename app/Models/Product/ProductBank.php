<?php

namespace App\Models\Product;

use App\Models\Practice\Practice;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBank extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $table = "product_banks";
    protected $fillable = [
        'bank_code',
        'bank_name',
    ];
    public function practices(){ return $this->belongsToMany(Practice::class,'product_practice_banks','practice_id','product_bank_id'); }
}

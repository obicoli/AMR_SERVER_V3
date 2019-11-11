<?php

namespace App\Models\Product\Supply;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Module\Module;

class GoodsOutNote extends Model
{
    use SoftDeletes, UuidTrait;
    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;
    protected $table = "goods_out_notes";
    protected $fillable = [
        'trans_number',
        'note',
        'trans_type'
    ];

    public function transactionable(){ return $this->morphTo();}
    public function owner(){ return $this->morphTo();}
    public function owning(){ return $this->morphTo();}
    
}

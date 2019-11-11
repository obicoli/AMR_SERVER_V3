<?php

namespace App\Models\Product\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;

class PoMovementStatus extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = "po_movement_statuses";

    protected $fillable = [
        'status',
        'description',
        'po_id'
    ];

    public function purchases(){ return $this->belongsTo(ProductPo::class,'po_id'); }
}

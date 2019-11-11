<?php

namespace App\Models\Emr\Orders;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabTemplate extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'lab_templates';

    protected $fillable = [
        'name',
        'slug'
    ];
    public function lab_order(){ return $this->morphMany(LabOrder::class, 'owner','owner_type','owner_id'); }
}

<?php

namespace App\Models\Emr\Orders;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestPanel extends Model
{
    use Accountable, SoftDeletes, UuidTrait;

    protected $table = 'test_panels';

    protected $fillable = [
        'name'
    ];

    public function lab_order(){ return $this->morphMany(LabOrder::class, 'owner','owner_type','owner_id'); }

}

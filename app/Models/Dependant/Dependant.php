<?php

namespace App\Models\Dependant;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dependant extends Model
{
    use SoftDeletes, Accountable, UuidTrait;

    protected $table = 'dependants';

    protected $fillable = [
        'first_name',
        'other_name',
        'gender',
        'age',
        'phone',
        'address',
        'relationship',
        'dependable_id', //1:M polymophy
        'dependable_type', //1:M polymophy
    ];

    public function dependable(){
        return $this->morphTo();
    }
}

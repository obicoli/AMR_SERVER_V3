<?php

namespace App\Models\Localization;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class County extends Model
{

    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'counties';

    protected $fillable = [
        'name',
        'region_id'
    ];

    public function region(){
        return $this->belongsTo(Region::class,'region_id');
    }
}

<?php

namespace App\Models\Emr\Notes;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExecuseActivity extends Model
{
    use UuidTrait, SoftDeletes, Accountable;

    protected $table = 'excuse_activities';

    protected $fillable = [
        'name'
    ];

    public function sick_note(){ return $this->hasMany(SickNote::class,'excusing_activity_id'); }
}

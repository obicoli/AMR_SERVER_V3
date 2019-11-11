<?php

namespace App\Models\Emr\Prescription;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrescriptEmr extends Model
{
    use SoftDeletes, Accountable, UuidTrait;

    protected $table = 'prescript_emrs';

    protected $fillable = [
        'instruction',
        'intake',
        'prescription_id',
    ];

    public function prescription(){ return $this->belongsTo(Prescription::class,'prescription_id'); }

}

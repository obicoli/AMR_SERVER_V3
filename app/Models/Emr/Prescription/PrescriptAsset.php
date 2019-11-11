<?php

namespace App\Models\Emr\Prescription;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrescriptAsset extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'prescript_emrs';

    protected $fillable = [
        'file_path',
        'file_mime',
        'prescription_id',
        'file_size',
    ];

    public function prescription(){ return $this->belongsTo(Prescription::class,'prescription_id'); }
}

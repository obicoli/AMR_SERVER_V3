<?php

namespace App\Models\Emr\Prescription;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescription extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = "prescriptions";

    const UPLOAD_PATH = "/storage/app/public/prescriptions/";

    public function assets(){ return $this->hasMany(PrescriptAsset::class,'prescription_id');}
    public function emr(){ return $this->hasMany(PrescriptEmr::class,'prescription_id');}

    public function owner()
    {
        return $this->morphTo();
    }

}

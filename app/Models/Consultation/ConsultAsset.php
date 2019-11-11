<?php

namespace App\Models\Consultation;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultAsset extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'consult_assets';

    protected $fillable = [
        'file_path',
        'file_mime',
        'consultation_id',
        'file_size',
    ];
}

<?php

namespace App\Models\Practice;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeAsset extends Model
{
    use Accountable, SoftDeletes, UuidTrait;

    protected $table = 'practice_assets';

    protected $fillable = [
        'file_path',
        'file_mime',
        'file_name',
        'file_size',
        'asset_type',
    ];

    public function assetable(){
        return $this->morphTo();
    }
}

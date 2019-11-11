<?php

namespace App\Models\Consultation;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalAsset extends Model
{
    use Accountable, SoftDeletes, UuidTrait;

    protected $table = 'medical_assets';

    protected $fillable = [
        'file_path',
        'file_mime',
        'file_name',
        'file_size',
        'asset_type',
        'asset_title',
    ];

    public function assetable(){
        return $this->morphTo();
    }

    public function users(){
        return $this->belongsToMany('App\Models\Users\User','medical_assets_users','medical_assets_id','user_id');
    }

    public function sms_notifications()
    {
        return $this->morphMany('App\Models\NotificationCenter\SmsNotification', 'sms_notificationsable','sms_notificationsable_type','sms_notificationsable_id','id');
    }

}

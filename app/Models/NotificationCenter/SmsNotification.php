<?php

namespace App\Models\NotificationCenter;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsNotification extends Model
{
    use UuidTrait, SoftDeletes, Accountable;

    protected $table = 'sms_notifications';

    protected $fillable = [
        'status',
        'user_id',
        'recipient_mobile',
        'message',
        'sms_notificationsable_id',
        'sms_notificationsable_type',
    ];

    public function sms_notificationsable()
    {
        return $this->morphTo();
    }

}

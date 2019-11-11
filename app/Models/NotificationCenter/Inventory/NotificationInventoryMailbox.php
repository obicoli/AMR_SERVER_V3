<?php

namespace App\Models\NotificationCenter\Inventory;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Module\Module;

class NotificationInventoryMailbox extends Model
{
    use UuidTrait, SoftDeletes, Accountable;

    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;

    protected $table = 'product_mail_boxes';

    protected $fillable = [
        'status',
        'subject',
        'msg',
        'email',
        'resend_count'
    ];

    public function owner(){ return $this->morphTo();}
    public function owning(){ return $this->morphTo();} //
    public function attatchments(){ return $this->hasMany(NotificationInventoryMailAttach::class,'product_mailbox_id');}
}

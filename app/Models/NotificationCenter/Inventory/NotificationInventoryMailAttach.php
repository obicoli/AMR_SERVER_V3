<?php

namespace App\Models\NotificationCenter\Inventory;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationInventoryMailAttach extends Model
{
    use UuidTrait, SoftDeletes, Accountable;
    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;
    protected $table = 'product_mail_attaches';

    protected $fillable = [
        'attachment_type',
    ];

    public function attachable(){ return $this->morphTo();}
    public function inventory_mailbox(){ return $this->belongsTo(NotificationInventoryMailbox::class,'product_mailbox_id'); }

}

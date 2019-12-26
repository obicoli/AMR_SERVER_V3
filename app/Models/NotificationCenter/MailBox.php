<?php

namespace App\Models\NotificationCenter;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailBox extends Model
{

    use UuidTrait, SoftDeletes, Accountable;

    const GRN_SUBJECT = "Goods Received Note";
    const PO_SUBJECT = "Purchase Order";
    const SPAYMENT_SUBJECT = "Supplier Payment";
    const BILL_SUBJECT = "Bill";
    const ESTIMATE_SUBJECT = "Estimate";
    const PO_MSG = "Please find our purchase order attached to this email.";
    const EST_MSG = "Please find our estimate attached to this email.";
    const GRN_MSG = "Please find our Goods Received Note attached to this email.";

    protected $table = 'mail_boxes';

    protected $fillable = [
        'status',
        'subject',
        'message',
        'to_',
        'resend_count'
    ];

    public function owner(){ return $this->morphTo();}

}

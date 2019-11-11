<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Product\Purchase\ProductPo;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $mailing_address;

    public $shipping_address;

    public $order_data;

    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $mailing_address, array $shipping_address, array $order_data, $subject)
    {
        $this->mailing_address = $mailing_address;
        $this->shipping_address = $shipping_address;
        $this->order_data = $order_data;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        switch ($this->subject){
            case ProductPo::MAIL_SUBJECT:
                    return $this->view('mails.orders.purchaseorder');
                break;
        }
    }
}

<?php

namespace App\Logic\Payments;



use App\Models\Account\Account;
use App\Models\Product\Order\Order;

class FundsProcess
{
    public function process_order_payment(Order $order)
    {
        $ft = new self();
        $ft->credit_user_wallet_for_order($order);
    }

    private function credit_user_wallet_for_order($order)
    {
        Account::credit($order->owner_id, $order->owner_type, 'main', $order->price, $order->notes, $order->id);
    }


}

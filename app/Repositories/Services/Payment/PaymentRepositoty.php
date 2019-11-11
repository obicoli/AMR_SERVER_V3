<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/18/18
 * Time: 8:04 PM
 */

namespace App\Repositories\Services\Payment;


use App\Models\Service\Payment;

class PaymentRepositoty implements PaymentRepositotyInterface
{
    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function find($id)
    {
        // TODO: Implement find() method.
        return $this->payment->find($id);
    }

    public function findByUserId($user_id)
    {
        // TODO: Implement findByUserId() method.
        return $this->payment->all()->where('user_id',$user_id)->first();
    }


}

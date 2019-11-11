<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/18/18
 * Time: 8:04 PM
 */

namespace App\Repositories\Services\Payment;


interface PaymentRepositotyInterface
{

    public function find($id);

    public function findByUserId($user_id);

}

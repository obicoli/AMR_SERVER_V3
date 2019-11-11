<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 1/23/19
 * Time: 3:18 PM
 */

namespace App\Contracts;


interface AccountableInterface
{

    public function getAccountId();
    public function getAccountName();
    public function getAccountType();

}

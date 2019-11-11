<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/19/18
 * Time: 8:09 PM
 */

namespace App\AfyaRTC\Friendlist;


interface CallableInterface
{

    /**
     * If caller sees and can call callee
     *
     * @param array $caller
     * @param array $callee
     * @return boolean
     */
    function canCall(array $caller, array $callee);

}

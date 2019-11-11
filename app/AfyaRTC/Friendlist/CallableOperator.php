<?php

namespace App\AfyaRTC\Friendlist;

class CallableOperator extends CallableBase implements CallableInterface {
    /**
     * If caller sees and can call callee
     * 
     * @param array $caller
     * @param array $callee
     * @return boolean
     */
    function canCall(array $caller, array $callee){
        $this->debug("FL/CallableOperator checking if caller:");
        $this->debug($caller);
        $this->debug("can call callee:");
        $this->debug($callee);
        //operator sees all and can call all
        if(isset($caller['operator']) && $caller['operator']){
            return true;
        }
        //only operator can be called
        if(isset($callee['operator']) && $callee['operator']){
            return true;
        }
        return false;
    }    
}

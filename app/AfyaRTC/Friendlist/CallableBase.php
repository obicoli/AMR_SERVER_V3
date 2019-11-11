<?php

namespace App\AfyaRTC\Friendlist;

abstract class CallableBase implements CallableInterface {

    /**
     * Configuration
     * 
     * @var array
     */
    protected $config;

    function __construct(array $config) {
        $this->config = $config;
    }

    /**
     * Var dump obj
     *
     * @param mixed $obj
     */
    public function debug($obj){
        if(!isset ($this->config['debug']) || !$this->config['debug']){
            return;
        }
        if(is_scalar($obj)){
            echo "$obj\n";
        }
        else{
            print_r($obj);
        }
    }
}

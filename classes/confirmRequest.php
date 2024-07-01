<?php

class ConfirmRequest{
    private $option;

    public function __construct()
    {   
        $this->option = null;
    }

    public function setOption(bool $option){
        $this->option = $option;
    }
    public function getOption(){
        return $this->option;
    }
}
<?php


class ConfirmRequest{
    private $option;

    public function setOption($option){
        $this->option = $option;
    }
    public function getOption(){
        return $this->option;
    }
}
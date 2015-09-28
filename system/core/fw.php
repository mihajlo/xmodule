<?php
/**
 * Description of module
 *
 * @author mihajlo
 */
class fw {
    public function __construct() {
        $this->module=new module();
    }
}


class module{
    public function load($name=false){
        if(!@include_once APPPATH.'modules/'.$name.'/'.$name.'.module.php'){
            require_once SYSTEMPATH.'modules/'.$name.'/'.$name.'.module.php';
        }
        $module = new $name();
        return $module;
    }
}

function module($v=false){
    if(!$v){
        return false;
    }
    $fw=new fw();
    return $fw->module->load($v)->index();
}


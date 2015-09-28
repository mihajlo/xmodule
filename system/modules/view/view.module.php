<?php

class view {

    public function index() {
        return $this;
    }

    public function get($path = false,$var=array()) {
        foreach($var as $key=>$val){
            ${$key}=$val;
        }
        
        global $config;
        if (!$path) {
            return false;
        }

        ob_start();
        include(SYSTEMPATH . '../' . $path);
        //ob_get_contents();
        $output = ob_get_clean();
        ob_clean();
        return $output;
        
    }

    public function load($path = false,$var=array()) {
        foreach($var as $key=>$val){
            ${$key}=$val;
        }
        global $config;
        if (!$path) {
            return false;
        }

        include(SYSTEMPATH . '../' . $path);
        
    }

}

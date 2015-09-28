<?php

if(!@$_SERVER['REQUEST_SCHEME']){
    $tmp=explode(':',@$_SERVER['SCRIPT_URI']);
    @$_SERVER['REQUEST_SCHEME']=$tmp[0];
}


class url {

    public function index() {
        return $this;
    }

    public function segment($segment=0) {
        $segments=explode('/',$_SERVER['QUERY_STRING']);
        return @$segments[$segment];
        
    }
    
    public function base_url(){
        return str_replace('index.php','',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']);
    }
    
    public function current_url(){
        return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }
    
    public function site_url($path=''){
        return $this->base_url().$path;
    }
    
    public function redirect($path){
        if(strpos($path, 'ttp:')){
            @header('Location:'.$path);
        }
        else{
            @header('Location:'.$this->base_url().$path);
        }
    }

}

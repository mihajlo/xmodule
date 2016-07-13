<?php

class jquery {

	public function index(){
		return $this;
	}
        
        public function load($ver='1.12.4'){
            
            if(file_exists('cache/permanent/jquery/'.$ver.'.js')){
              return '<script src="'.str_replace('index.php','',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']).'cache/permanent/jquery/'.$ver.'.js"></script>';
            }
            $jq_content=  @file_get_contents('https://ajax.googleapis.com/ajax/libs/jquery/'.$ver.'/jquery.min.js');
            @file_put_contents('cache/permanent/jquery/'.$ver.'.js',$jq_content);
            return '<script src="'.str_replace('index.php','',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']).'cache/permanent/jquery/'.$ver.'.js"></script>';
        }

}
<?php

class header {
    
    public function index() {
        return $this;
    }
    
    public function h1($str=''){
        return '<h1>'.$str.'</h1>';
    }
    
    
}

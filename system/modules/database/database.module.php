<?php

class database {
    
    public function index() {
        return $this->load();
    }
    
    public function load() {
        global $db;
        return $db;
    }
    
    
}

<?php

class language {

    public function index() {
        $this->lang=$this->load();
        return $this;
    }

    public function load($l='en') {
        $lang=@json_decode(@file_get_contents(APPPATH.'languages/'.$l.'.json'));
        $this->lang=$lang;
        return $lang;
    }
}

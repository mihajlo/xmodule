<?php

class rest {

    public function index() {
        return $this;
    }

    public function response($arr=array(),$status=true) {
        @header("Access-Control-Allow-Origin: *");
        $output['status']=$status;
        if(!$status){
            @header('HTTP/1.1 500 Internal Server Error');
            $output['error']=true;
        }
        $output['data']=$arr;
        echo json_encode($output);
        exit;
    }
}

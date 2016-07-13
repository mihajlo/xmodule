<?php

class email {

	public function index(){
		$this->from_name='Xmodule';
		$this->from_email='xmodule@xmodule.eco.mk';
		$this->message='An example message of Xmodule PHP framework';
		return $this;
	}
        
        public function send($to){
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: '.$this->from_name.'<'.$this->from_email.'>' . "\r\n";
            if(@mail($to,$subject,$this->message,$headers)){
                return true;
            }
            else{
                return false;
            }
        
        }

}
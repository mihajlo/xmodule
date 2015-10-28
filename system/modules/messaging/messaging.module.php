<?php

class messaging {
     
    public function index(){
        
        global $db;
        global $config;
        $default_user='admin';
        
        if (!$db->table_exists($config['appId'].'_msg')){
            
            $db->query("CREATE TABLE IF NOT EXISTS `".$config['appId']."_msg` (
  `id` int(11) NOT NULL,
  `client_id` varchar(100) NOT NULL,
  `msg` longtext,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8");
            
            
            $db->query("ALTER TABLE `".$config['appId']."_msg`
                            ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`)");
            
            $db->query("ALTER TABLE `".$config['appId']."_msg`
                             MODIFY `id` int(11) NOT NULL AUTO_INCREMENT");
            
        }
        
        
        return $this;
    }
    
    public function send($client=false,$msg=false){
        if(!$client || !$msg){
            return false;
        }
        global $db;
        global $config;
        
        $for_insert=array(
            'client_id'=>$client,
            'msg'=>$msg
        );
    if(@$db->insert($config['appId']."_msg",$for_insert)){
        return true;
    }
    return false;
        
    }
    
    public function get($client=false){
        if(!$client){
            return false;
        }
        global $db;
        global $config;
        $msgs=  $db->query("SELECT * FROM ".$config['appId']."_msg WHERE client_id='".$client."' ORDER BY id ASC LIMIT 1")->result_array();
    
        if(count($msgs)>0){
            $db->delete($config['appId']."_msg",array('id'=>$msgs[0]['id']));
            return $msgs[0]['msg'];
        }
        return false;
    }
    
    
    
}

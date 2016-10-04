<?php

class user {
    
    public function index(){
        
        global $db;
        global $config;
        $default_user='admin';
        
        if (!$db->table_exists($config['appId'].'_auth_user')){
            
            $db->query("CREATE TABLE IF NOT EXISTS `".$config['appId']."_auth_user` (
                            `id` int(11) NOT NULL,
                            `userkey` varchar(128) NOT NULL,
                            `role` varchar(50) NOT NULL DEFAULT 'user',
                            `username` varchar(128) NOT NULL,
                            `password` varchar(60) NOT NULL,
                            `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
                          ) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8");
            
            
            $db->query("ALTER TABLE `".$config['appId']."_auth_user`
                            ADD PRIMARY KEY (`id`),
                            ADD UNIQUE KEY `unique_key` (`userkey`)");
            
            $db->query("ALTER TABLE `".$config['appId']."_auth_user`
                            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2");
            
        }
        
        if (!$db->table_exists($config['appId'].'_auth_user_info')){
            
            $db->query("CREATE TABLE IF NOT EXISTS `".$config['appId']."_auth_user_info` (
                        `user_id` int(11) NOT NULL,
                        `ukey` varchar(50) NOT NULL,
                        `uvalue` text
                      ) ENGINE=MyISAM DEFAULT CHARSET=utf8");
            
            $db->query("ALTER TABLE `".$config['appId']."_auth_user_info`
                        ADD UNIQUE KEY `unique_key_per_user` (`user_id`,`ukey`)");
            
        }
        
        return $this;
    }
    
    public function get($val,$field='id'){
        global $db;
        global $config;
        $u=$db->query("SELECT ".$config['appId']."_auth_user.* FROM ".$config['appId']."_auth_user WHERE ".$field."='".$val."' ORDER BY id ASC")->result_array();
        if(count($u)==1){
            
            $userData=$db->query("SELECT * FROM ".$config['appId']."_auth_user_info WHERE user_id=".$u[0]['id'])->result_array();
            $data=array();
            foreach($userData as $row){
                $data[$row['ukey']]=$row['uvalue'];
            }
            $u[0]['more']=$data;
            return $u[0];
        }
        else if(count($u)>1){
            $uu=array();
            foreach($u as $usr){
                $userData=$db->query("SELECT * FROM ".$config['appId']."_auth_user_info WHERE user_id=".$usr['id'])->result_array();
                $data=array();
                foreach($userData as $row){
                    $data[$row['ukey']]=$row['uvalue'];
                }
                $usr['more']=$data;
                $uu[]=$usr;
            }
           
            
            return $uu;
        }
        return false;
    }
    
    public function create($user=false){
        global $db;
        global $config;
        $user['userkey']=md5($config['appId'].'_'.$user['username']);
        $user['password']=md5($config['appId'].'_'.$user['password'].'_pswd');
        $more=@$user['more'];
        unset($user['more']);
        if(@$db->insert($config['appId'].'_auth_user',$user)){
            $uid = $db->insert_id();
            if(@$more){
                foreach($more as $key=>$value){
                    $db->insert($config['appId']."_auth_user_info",array(
                        'user_id'=>$uid,
                        'ukey'=>$key,
                        'uvalue'=>$value
                    ));
                }
            }
            
            return $this->get($uid);
        }
        return false;
    }
    
    public function delete($uid=0){
        global $db;
        global $config;
        if(@$db->delete($config['appId'].'_auth_user',array('id'=>$uid))){
            @$db->delete($config['appId']."_auth_user_info",array('user_id'=>$uid));
            return true;
        }
        return false;
        
    }
    
    public function update($uid=false,$user=false){
        if(!$uid){
            return false;
        }
        global $db;
        global $config;
        
        if(!$this->get($uid)){
            return false;
        }
        unset($user['id']);
        unset($user['userkey']);
        unset($user['created']);
        if(@$user['more']){
            foreach($user['more'] as $key=>$value){
                $db->delete($config['appId']."_auth_user_info",array('ukey'=>$key,'user_id'=>$uid));
                if($value){
                    $db->insert($config['appId']."_auth_user_info",array(
                        'user_id'=>$uid,
                        'ukey'=>$key,
                        'uvalue'=>$value
                    ));
                }
            }
        }
        unset($user['more']);
        if($user['password']){
            $user['password']=md5($config['appId'].'_'.$user['password'].'_pswd');
        }       
        $keyUpdate=false;
        if(@$user['username']){
            $keyUpdate=true;
            $user['userkey']=md5($config['appId'].'_'.$user['username']);
        }
        
        if($keyUpdate){
            if(!@$db->update($config['appId'].'_auth_user',$user,array('id'=>$uid)) ){
                return false;
            }
        }
        else{
            @$db->update($config['appId'].'_auth_user',$user,array('id'=>$uid));
        }
        
        return $this->get($uid);
    }
    
    public function auth($username=false,$password=false){
        global $config;
        global $db;
        
        $u=$db->query("SELECT * FROM ".$config['appId']."_auth_user WHERE "
                . "username='".trim($username)."' "
                . "AND password = '".md5($config['appId'].'_'.trim($password).'_pswd')."' LIMIT 1")->result_array();
        if(count($u)){
            @session_start();
            @$_SESSION[$config['appId'].'_logged']=$this->get($u[0]['username'],'username');
            return true;
        }
        return false;
    }
    
    public function get_auth_user(){
        global $config;
        global $db;
        @session_start();
        if(@$_SESSION[$config['appId'].'_logged']){
            return @$_SESSION[$config['appId'].'_logged'];
        }
        return array();
    }
    
    public function is_logged(){
        global $config;
        global $db;
        @session_start();
        if(@$_SESSION[$config['appId'].'_logged']){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function destroy(){
        global $config;
        global $db;
        @session_start();
        unset($_SESSION[$config['appId'].'_logged']);
    }
    
}

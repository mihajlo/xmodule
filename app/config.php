<?php

//Default configuration
$config['default']=array(
    'site_name'=>'Example site name',
    'appId'=>'mysite',
    'version'=>'2.6',
    //environment configuration ex('development','test','production')
    'environment'=>'development',
    
    
    //database configuration
    'database'=>array(
        'hostname'=>'localhost:3306',
        'username'=>'root',
        'password'=>'',
        'database'=>'example',
        'driver'=>'mysqli',
        'load'=>FALSE 
    ),
    
    'storage_id'=>'mysite_storage',
    
    //set default page
    'page'=>'home',
    
    //ERROR 404 page
    'page404'=>'404',
    
    //user roles
    'roles'=>array(
        'admin',
        'user'
    ),
    
    'theme_path'=>'themes/simple/'
    
);


//load configuration
load_configuration('default');

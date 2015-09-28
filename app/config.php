<?php

//Default configuration
$config['default']=array(
    'appId'=>'x1',
    
    //environment configuration ex('development','test','production')
    'environment'=>'development',
    
    
    //database configuration
    'database'=>array(
        'hostname'=>'localhost:3306',
        'username'=>'root',
        'password'=>'root',
        'database'=>'testdatabase',
        'driver'=>'mysqli',
        'load'=>FALSE 
    ),
    
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

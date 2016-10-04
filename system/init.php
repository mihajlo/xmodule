<?php
if(strtolower(@$_SERVER['REQUEST_METHOD'])!='delete' && strtolower(@$_SERVER['REQUEST_METHOD'])!='post' && strtolower(@$_SERVER['REQUEST_METHOD'])!='get'){
            @header('HTTP/1.1 405 Method Not Allowed');
            echo 'Method Not Allowed';
            exit;
}

define('BASEPATH', realpath(dirname(__FILE__)).'/');
define('APPPATH', realpath('.').'/app/');
define('SYSTEMPATH', realpath('.').'/system/');

require_once SYSTEMPATH.'core/Common.php';
require_once SYSTEMPATH.'core/fw.php';
require_once SYSTEMPATH.'database/DB.php';
require_once SYSTEMPATH.'core/load.php';
require_once APPPATH.'config.php';





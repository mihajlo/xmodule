<?php
$url=module('url');
$view = module('view');
$h=module('header');

$view->load('themes/simple/home_page.php',array(
	'documentation_link'=>'http://xmodule.work/',
	'hmodule'=>$h
));

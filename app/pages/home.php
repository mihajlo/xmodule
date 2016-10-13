<?php
$view = module('view');
$url=module('url');

$view->load($config['theme_path'].'home_page.php',
        [
            'hmodule'=>module('header'),
            'documentation_link'=>'https://xmodule.eco.mk/documentation'
        ]
    );
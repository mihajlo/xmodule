<?php

function &load_database($params = '', $active_record_override = false) {
    $database = & DB($params, $active_record_override);
    return $database;
}

function load_configuration($conf = false) {
    if (!$conf) {
        exit('no configuration loaded');
    }
    global $config;

    $config = $config[$conf];

    if ($config['database']['load']) {
        $GLOBALS['db'] = & load_database($config['database']['driver'] . "://" . $config['database']['username'] . ":" . $config['database']['password'] . "@" . $config['database']['hostname'] . "/" . $config['database']['database'], true);
    }
    $url=module('url');
    if (!@$url->segment(1)) {
        require_once APPPATH . '/pages/' . $config['page'] . '.php';
    } else {
        if (!@include_once(APPPATH . '/pages/' . @$url->segment(1) . '.php')) {
            require_once APPPATH . '/pages/' . $config['page404'] . '.php';
        }
    }
}

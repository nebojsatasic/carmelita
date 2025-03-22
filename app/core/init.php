<?php

session_start();

$GLOBALS['config'] = [
    'app_name' => 'Carmelita',
    'domain' => 'https://carmelita.nebojsatasic.com/',
    'db' => [
        'host' => 'localhost',
        'user' => '',
        'password' => '',
        'db_type' => 'mysql',
        'db_name' => '',
    ],
    'app_dir' => '/var/www/carmelita',
];

spl_autoload_register(function ($className) {
    if (file_exists('app/config/' . $className . '.php')) {
        require_once 'app/config/' . $className . '.php';
    } elseif (file_exists('app/database/' . $className . '.php')) {
        require_once 'app/database/' . $className . '.php';
    } elseif (file_exists('app/controllers/' . $className . '.php')) {
        require_once 'app/controllers/' . $className . '.php';
    } elseif (file_exists('app/models/' . $className . '.php')) {
        require_once 'app/models/' . $className . '.php';
    } elseif (file_exists('app/helpers/' . $className . '.php')) {
        require_once 'app/helpers/' . $className . '.php';
    } elseif (file_exists('app/controllers/admin/' . $className . '.php')) {
        require_once 'app/controllers/admin/' . $className . '.php';
    }
});

Model::init();

require 'vendor/autoload.php';

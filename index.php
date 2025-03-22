<?php

require_once 'app/core/init.php';

if (isset($_GET['url'])) {
    $url = trim(strip_tags($_GET['url']));
    $url = explode('/', $url);
$params = [];

    if ((count($url) > 1) && class_exists(trim($url[0]) . 'Controller') && method_exists(trim($url[0]) . 'Controller', trim($url[1]))) {
        $controller = trim($url[0]) . 'Controller';
        $method = trim($url[1]);
        array_shift($url);
        array_shift($url);

        if ((count($url) > 0)) {
            for ($i = 0; $i < count($url); $i += 2) {
                if (isset($url[$i + 1])) {
                    $params[trim($url[$i])] = trim($url[$i + 1]);
                } else {
                    $params[trim($url[$i])] = null;
                }
            }
        }
    } else {
        $controller = 'ProductController';
        $method = 'index';
    }

    $c = new $controller();
    $c->$method($params);
} else {
    $c = new ProductController();
    $c->index();
}

<?php

require 'vendor/autoload.php';

$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/home';

$routes = require 'Config/routes.php';

if (!array_key_exists($path, $routes)) {
    http_response_code(404);
    exit();
}

$classControler = $routes[$path];

$controller = new $classControler();
$controller->processReq();

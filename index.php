<?php

require 'vendor/autoload.php';

$path = isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : '/home';

$routes = require 'Config/routes.php';

if (!array_key_exists($path, $routes)) {
    http_response_code(404);
    exit();
}

$classControler = $routes[$path];

$controller = new $classControler();
$controller->processReq();

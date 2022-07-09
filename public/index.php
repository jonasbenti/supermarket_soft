<?php

require __DIR__ . '/../vendor/autoload.php';

$path = $_SERVER['PATH_INFO'];
$routes = require __DIR__ . '/../Config/routes.php';

if (!array_key_exists($path, $routes)) {
    http_response_code(404);
    exit();
}

$classControler = $routes[$path];

$controller = new $classControler();
$controller->processReq();

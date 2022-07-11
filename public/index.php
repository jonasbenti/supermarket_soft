<?php

require __DIR__ . '/../vendor/autoload.php';

// Valida se a aplicacao esta local ou hospedado no Heroku
if (isset($_SERVER['HEROKU_APP_DIR'])) {
    $path = isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : '/home';
} else {
    $path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/home';
}

$routes = require __DIR__ . '/../Config/routes.php';

if (!array_key_exists($path, $routes)) {
    http_response_code(404);
    exit();
}

$classControler = $routes[$path];

$controller = new $classControler();
$controller->processReq();

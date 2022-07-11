<?php

require __DIR__ . '/../vendor/autoload.php';

$path = isset($_SERVER['HEROKU_APP_DIR']) ? $_SERVER['REDIRECT_URL'] : $_SERVER['PATH_INFO'];
PHP_EOL.PHP_EOL;
var_dump($path);
$path = $path ?: '/home';
var_dump($_SERVER);
PHP_EOL.PHP_EOL;
var_dump($path);

$routes = require __DIR__ . '/../Config/routes.php';

if (!array_key_exists($path, $routes)) {
    http_response_code(404);
    exit();
}

$classControler = $routes[$path];

$controller = new $classControler();
$controller->processReq();

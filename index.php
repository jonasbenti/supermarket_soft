<?php

require 'vendor/autoload.php';

// Valida se existe a REDIRECT_URL(HEROKU), caso nao exista utiliza a PATH_INFO (Localhost)
$path = isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : $_SERVER['PATH_INFO'];

$routes = require 'Config/routes.php';

if (!array_key_exists($path, $routes)) {
    http_response_code(404);
    exit();
}

$classControler = $routes[$path];

$controller = new $classControler();
$controller->processReq();

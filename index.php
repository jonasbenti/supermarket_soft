<?php

function my_autoload($class)
{
    $dir_src = './App/Controller/';

    if (file_exists($dir_src.$class. '.php')) {
        require_once $dir_src.$class . '.php';
    }
}

spl_autoload_register("my_autoload");

$classe = isset($_REQUEST['class']) ? $_REQUEST['class'] : null;
$metodo = isset($_REQUEST['method']) ? $_REQUEST['method'] : null;

if (class_exists($classe)) {
    $pagina = new $classe($_REQUEST);

    if (!empty($metodo) && method_exists($classe, $metodo)) {
        $pagina->$metodo($_REQUEST);
    }

    $pagina->show();
} else {
    header("Location: index.php?class=InitList");
}

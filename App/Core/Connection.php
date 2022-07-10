<?php

namespace App\SupermarketSoft\Core;

use PDO;

class Connection
{
    private function __construct() {}

    /**
     * Abre a conexao com o banco de dados
     *
     * @return PDO
     */
    public static function open(): PDO
    {
        $dbuser = getenv('dbuser') ? getenv('dbuser') : null;
        $dbpass = getenv('dbpass') ? getenv('dbpass') : null;
        $dbname = getenv('dbname') ? getenv('dbname') : null;
        $dbhost = getenv('dbhost') ? getenv('dbhost') : null;
        $dbtype = getenv('dbtype') ? getenv('dbtype') : null;
        $conn = new PDO("{$dbtype}:dbname={$dbname} host={$dbhost}", $dbuser, $dbpass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}

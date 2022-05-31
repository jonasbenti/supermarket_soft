<?php

class Connection
{
    private function __construct() {}

    public static function open()
    {
        $dbuser = getenv('dbuser') ? getenv('dbuser') : null;
        $dbpass = getenv('dbpass') ? getenv('dbpass') : null;
        $dbname = getenv('dbname') ? getenv('dbname') : null;
        $dbhost = getenv('dbhost') ? getenv('dbhost') : null;
        $dbtype = getenv('dbtype') ? getenv('dbtype') : null;
        $dbport = getenv('dbport') ? getenv('dbport') : 5432;
        $conn = new PDO("{$dbtype}:dbname={$dbname} host={$dbhost}", $dbuser, $dbpass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}

<?php

class Connection
{
    private function __construct() {}

    public static function open()
    {
        if (file_exists(".env")) {
            $db = parse_ini_file(".env");
        } else {
            throw new Exception("Arquivo .env não encontrado");
        }
        $dbuser = isset($db['dbuser']) ? $db['dbuser'] : null;
        $dbpass = isset($db['dbpass']) ? $db['dbpass'] : null;
        $dbname = isset($db['dbname']) ? $db['dbname'] : null;
        $dbhost = isset($db['dbhost']) ? $db['dbhost'] : null;
        $dbtype = isset($db['dbtype']) ? $db['dbtype'] : null;
        $dbport = isset($db['dbport']) ? $db['dbport'] : 5432;
        $conn = new PDO("{$dbtype}:dbname={$dbname} host={$dbhost}", $dbuser, $dbpass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}

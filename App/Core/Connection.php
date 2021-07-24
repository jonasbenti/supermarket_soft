<?php

class Connection
{
    private function __construct() {}
    
    public static function open($name)
    {
        if (file_exists("App/Config/{$name}.ini")) {
            $db = parse_ini_file("App/Config/{$name}.ini");
        } else {
            throw new Exception("Arquivo {$name} não encontrado");
        }
        $user = isset($db['user']) ? $db['user'] : null;
        $pass = isset($db['pass']) ? $db['pass'] : null;
        $name = isset($db['name']) ? $db['name'] : null;
        $host = isset($db['host']) ? $db['host'] : null;
        $type = isset($db['type']) ? $db['type'] : null;
        $port = isset($db['port']) ? $db['port'] : 5432;
        
        $conn = new PDO("{$type}:dbname={$name} host={$host}", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
}

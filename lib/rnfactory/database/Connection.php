<?php

namespace rnfactory\database;

use PDO;
use Exception;

final class Connection
{
    private function __construct()
    {
    }

    public static function open($name)
    {
        if (file_exists("app/database/{$name}.ini")) {
            $db = parse_ini_file("app/database/{$name}.ini");
        } else {
            throw new Exception("Arquivo '$name' não encontrado");
        }

        $user = isset($db['user']) ? $db['user'] : NULL;
        $pass = isset($db['pass']) ? $db['pass'] : NULL;
        $name = isset($db['name']) ? $db['name'] : NULL;
        $host = isset($db['host']) ? $db['host'] : NULL;
        $type = isset($db['type']) ? $db['type'] : NULL;
        $port = isset($db['port']) ? $db['port'] : NULL;

        switch ($type) {
            case 'mysql':
                $port = $port ? $port : '3308';
                $conn = new PDO("mysql:host={$host};port={$port};dbname={$name}", $user, $pass);
                break;
            case 'mariadb':
                $port = $port ? $port : '3306';
                $conn = new PDO("mysql:host={$host};port={$port};dbname={$name}", $user, $pass);
                break;
        }

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
}

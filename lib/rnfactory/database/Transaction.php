<?php

namespace rnfactory\database;

use rnfactory\database\Connection;

final class Transaction
{
    private static $conn;

    private function __construct()
    {
    }

    public static function open($database)
    {
        if (empty(self::$conn)) {
            self::$conn = Connection::open($database);
            self::$conn->beginTransaction();
        }
    }

    public static function get()
    {
        return self::$conn;
    }

    public static function rollback()
    {
        if (self::$conn) {
            self::$conn->rollback();
            self::$conn = NULL;
        }
    }

    public static function close()
    {
        if (self::$conn) {
            self::$conn->commit();
            self::$conn = NULL;
        }
    }
}

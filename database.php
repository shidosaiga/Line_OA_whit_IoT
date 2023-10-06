<?php

class Database
{

    private static $dbHost = 'localhost';

    private static $dbName = 'iot_db';

    private static $dbUsername = 'root';

    private static $dbUserPassword = '';

    private static $cont = null;

    public static function connect()
    {
        if (null == self::$cont) {
            try {
                self::$cont = new PDO("mysql:host=" . self::$dbHost . ";" . "dbname=" . self::$dbName, self::$dbUsername, self::$dbUserPassword);
                self::$cont->exec("SET NAMES utf8mb4");
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return self::$cont;
    }

    public static function disconnet()
    {
        self::$cont = null;
    }
}

$db = Database::connect();

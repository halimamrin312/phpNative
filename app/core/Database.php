<?php

class Database
{
    private static $instance = null;

    private function __construct()
    {
    }

    /**
     * @return PDO
     */

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $host = '127.0.0.1';
            $dbname = 'myLocker';
            $username = 'root';
            $password = '';

            $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

            try {
                self::$instance = new PDO(
                    $dsn,
                    $username,
                    $password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
                echo ' DB Connected</br></br>';
            } catch (PDOException $e) {
                die('DB Connection Failed :' . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
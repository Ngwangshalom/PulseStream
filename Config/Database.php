<?php

namespace Config\Database;

class Database
{
    private static $instance;
    private $connection;

    private function __construct()
    {
        // Implement your database connection logic here
        // You can use a database library or write custom database connection code
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'pulsestream';

        $this->connection = new \mysqli($host, $username, $password, $database);

        if ($this->connection->connect_error) {
            die('Database connection failed: ' . $this->connection->connect_error);
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}

<?php
// company: PulseStream
// Developed by: Ngwang Shalom
// Location: Cameroon/Bamenda
// Languages: php/hack/javascript/node(library)
// position: Senior dev
//
//
// Please add your own description if you are a contributor
// as far as you are a contributor
//
//
namespace Config;

class Database
{
    private static $instance;
    private $connection;

    public function __construct()
    {
        $config = require_once __DIR__ . '/PulseFig/config.php';

        //get most
        // Retrieve the database credentials from the configuration file
        $host = $config['host'];
        $username = $config['username'];
        $password = $config['password'];
        $database = $config['database'];

        try {
            $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->connection = new \PDO($dsn, $username, $password, $options);
        } catch (\PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}

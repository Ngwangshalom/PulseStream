<?php
// company: PulseStream
// Developed by: Ngwang Shalom
// Location: Cameroon/Bamenda
// Languages: php/hack/javascript/node(library)
// position: Senior dev
//
//
// Please add your own description if you are a contributor
//
//
//
namespace app\web\MiddleWare;

use PDO; // Assuming you're using PDO for database access

class UserRepository
{
    private $db;

    public function __construct()
    {
        // Initialize the database connection
        $dsn = 'mysql:host=localhost;dbname=pulsestream;charset=utf8';
        $username = 'root';
        $password = '';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $this->db = new PDO($dsn, $username, $password, $options);
    }

    public function findByUsername($username)
    {
        // Prepare the query
        $query = "SELECT * FROM pulse_users WHERE username = :username";
        $statement = $this->db->prepare($query);

        // Bind the parameter and execute the query
        $statement->bindParam(':username', $username);
        $statement->execute();

        // Fetch the user record
        $user = $statement->fetch();

        return $user;
    }
}

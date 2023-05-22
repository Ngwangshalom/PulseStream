<?php

namespace app\API\Controllers;

use app\Web\MiddleWare\UserRepository;
use app\Web\MiddleWare\ValidateRequest;
use app\Web\MiddleWare\EncryptData;
// use Config\Database;
use app\Web\MiddleWare\handleSuccess;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../../../vendor/autoload.php';
// require_once __DIR__ . '/../../../app/Web/MiddleWare/UserRepository.php';
// require_once '../../Config/Database.php';


class AuthController
{
    public static function login()
{
    // Retrieve the request body
    $requestBody = file_get_contents('php://input');

    // Decode the request body as JSON
    $requestData = json_decode($requestBody, true);

    // Retrieve the username and password from the decoded JSON data
     $username = $requestData['username'];
     $password = $requestData['password'];
 // Retrieve user credentials from the request and sanitize the input
//  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
//  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Validate the input
    if (empty($username) || empty($password)) {
        // Invalid input, redirect back to the login page
        // header('Location: /Failed');
        echo "Invalid input";
        exit();
    }

    // Authenticate the user based on the provided credentials
    // Assume UserRepository is properly implemented and handles database operations
    $userRepository = new UserRepository();
    $user = $userRepository->findByUsername($username);

    if ($user && password_verify($password, $user['password'])) {
        // Authentication successful, set the user ID in the session
        $_SESSION['user_id'] = $user['id'];

        // Generate a CSRF token and assign it to the user
        $csrfToken = bin2hex(random_bytes(32));
        $user['csrf_token'] = $csrfToken;

        // Redirect to the success handler with the user's role
        $successHandler = new handleSuccess();
        $successHandler->handleSuccess($user['role']);

        exit();
    } else {
        // Authentication failed, redirect back to the login page
        // header('Location: /Failed');
        echo "Authentication failed";
        exit();
    }
}
public static function register()
{
    // Retrieve the JSON data from the request body
    $requestData = json_decode(file_get_contents('php://input'), true);

    // Retrieve the username, password, and country from the submitted JSON data
    $username = $requestData['username'] ?? '';
    $password = $requestData['password'] ?? '';
    $country = $requestData['country'] ?? '';

    // Perform validations and database operations
    // ...

    // Example: Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Example: Create a database connection
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'pulsestream';

    $connection = new \mysqli($servername, $username, $password, $database);

    // Check the connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Example: Store the registration data in the database
    $query = "INSERT INTO pulse_users (username, password, country) VALUES (?, ?, ?)";
    $statement = $connection->prepare($query);
    $statement->bind_param('sss', $username, $hashedPassword, $country);

    if ($statement->execute()) {
        // Registration successful
        $response = [
            'status' => 'success',
            'message' => 'Registration successful.'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    } else {
        // Registration failed
        $response = [
            'status' => 'error',
            'message' => 'Registration failed. Please try again.'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}


    
        public static function logout()
        {
            // Handle logout logic
    
            // Example: Clear the user session
            // $session->clear();
    
            // Redirect to the login page or a home page
            echo "logged out";
            // header('Location: /api/login');<
            exit();
        }
    }
    


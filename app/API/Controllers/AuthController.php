<?php

namespace app\API\Controllers;

use app\Web\MiddleWare\UserRepository;
use app\Web\MiddleWare\ValidateRequest;
use app\Web\MiddleWare\EncryptData;
use Config\Database;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../../../vendor/autoload.php';
// require_once __DIR__ . '/../../../app/Web/MiddleWare/UserRepository.php';


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
        $successHandler = new SuccessHandler();
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
    // Retrieve form data
    $id = $_POST['id'] ?? '';
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $username = $_POST['username'] ?? '';
    $phoneNumber = $_POST['phone_number'] ?? '';
    $email = $_POST['email'] ?? '';
    $country = $_POST['country'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    $session = $_POST['session'] ?? '';

    // Perform validations
    $validationErrors = [];

    // Check if the fields are required and not empty
    if (empty($id)) {
        $validationErrors['id'] = "The field 'id' is required.";
    }
    if (empty($firstName)) {
        $validationErrors['first_name'] = "The field 'first_name' is required.";
    }
    if (empty($lastName)) {
        $validationErrors['last_name'] = "The field 'last_name' is required.";
    }
    if (empty($username)) {
        $validationErrors['username'] = "The field 'username' is required.";
    }
    if (empty($phoneNumber)) {
        $validationErrors['phone_number'] = "The field 'phone_number' is required.";
    }
    if (empty($email)) {
        $validationErrors['email'] = "The field 'email' is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validationErrors['email'] = "Invalid email format for field 'email'.";
    }
    if (empty($country)) {
        $validationErrors['country'] = "The field 'country' is required.";
    }
    if (empty($password)) {
        $validationErrors['password'] = "The field 'password' is required.";
    }
    if (empty($role)) {
        $validationErrors['role'] = "The field 'role' is required.";
    }
    if (empty($session)) {
        $validationErrors['session'] = "The field 'session' is required.";
    }

    // If there are validation errors, redirect back to the registration page with error messages
    if (!empty($validationErrors)) {
        $_SESSION['validation_errors'] = $validationErrors;
        header('Location: /api/register');
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Example: Store the registration data in the database
    $db = Database::getInstance();
    $connection = $db->getConnection();

    $query = "INSERT INTO users (id, first_name, last_name, username, phone_number, email, country, password, role, session) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $statement = $connection->prepare($query);
    $statement->bind_param(
        'ssssssssss',
        $id,
        $firstName,
        $lastName,
        $username,
        $phoneNumber,
        $email,
        $country,
        $hashedPassword,
        $role,
        $session
    );

    if ($statement->execute()) {
        // Registration successful, redirect to login page
        header('Location: /Success');
        exit();
    } else {
        // Registration failed, redirect back to the registration page with a response
        $response = "Registration failed. Please try again.";
        header('Location: /Failed');
        exit();
    }
}

    
        public static function logout()
        {
            // Handle logout logic
    
            // Example: Clear the user session
            // $session->clear();
    
            // Redirect to the login page or a home page
            header('Location: /login');
            exit();
        }
    }
    


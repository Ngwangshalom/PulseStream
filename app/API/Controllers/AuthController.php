<?php

namespace app\API\Controllers;

use app\Web\MiddleWare\UserRepository;
use app\Web\MiddleWare\FormValidator;
use app\Web\MiddleWare\PasswordHasher;
// use Config\Database;
use app\Web\MiddleWare\handleSuccess;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../../../vendor/autoload.php';
// require_once __DIR__ . '/../../../app/Web/MiddleWare/UserRepository.php';
use Config\Database;


class AuthController
{
    public static function login()
    {
        // Retrieve the username and password from the form data
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Check if the username and password are provided
        if (empty($username) || empty($password)) {
            $response = [
                'status' => 'error',
                'message' => 'Username and password are required.'
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }

        // Create an instance of the Database class for the database connection
        $database = new Database();

        // Perform the login data validation and check against the database
        // ...

        // Example: Check if the username exists in the database and compare the password
        $query = "SELECT * FROM pulse_users WHERE username = :username";
        $statement = $database->getConnection()->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($result) {
            $hashedPassword = $result['password'];

            // Verify the password
            if (password_verify($password, $hashedPassword)) {
                // Login successful
                $response = [
                    'status' => 'success',
                    'message' => 'Login successful.'
                ];
            } else {
                // Invalid password
                $response = [
                    'status' => 'error',
                    'message' => 'Invalid username or password.'
                ];
            }
        } else {
            // User not found
            $response = [
                'status' => 'error',
                'message' => 'Invalid username or password.'
            ];
        }

        // Send the JSON response to the frontend
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
    
    
    public static function register()
{
    // Retrieve the registration data from the $_POST array
    $username = $_POST['username'] ?? '';
    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $sex = $_POST['sex'] ?? '';

    // Validate the form input
    $validator = new FormValidator();
    $validationErrors = $validator->validate([
        'username' => 'required|unique',
        'firstname' => 'required',
        'lastname' => 'required',
        'email' => 'required|email|unique',
        'phone' => 'required',
        'password' => 'required',
        // Add other validation rules for the remaining fields
    ]);

    // Check if there are any validation errors
    if (!empty($validationErrors)) {
        $response = [
            'status' => 'error',
            'message' => 'Invalid registration data. Please check your input.',
            'errors' => $validationErrors
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    // Hash the password
    $passwordHasher = new PasswordHasher();
    $hashedPassword = $passwordHasher->hashPassword($password);

    // Get the database connection
    $database = Database::getInstance()->getConnection();

    // Store the registration data in the database
    $query = "INSERT INTO pulse_users (username, firstname, lastname, email, phone, password, sex, role) VALUES (:username, :firstname, :lastname, :email, :phone, :password, :sex, :role)";
    $statement = $database->prepare($query);
    $statement->bindParam(':username', $username);
    $statement->bindParam(':firstname', $firstname);
    $statement->bindParam(':lastname', $lastname);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':phone', $phone);
    $statement->bindParam(':password', $hashedPassword);
    $statement->bindParam(':sex', $sex);
    $statement->bindValue(':role', 'user');

    if ($statement->execute()) {
        // Registration successful
        $response = [
            'status' => 'success',
            'message' => 'Registration successful.',
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    } else {
        // Registration failed
        $response = [
            'status' => 'error',
            'message' => 'Registration failed. Please try again.',
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
            // header('Location: /api/login');
            exit();
        }
    }
    

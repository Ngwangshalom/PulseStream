<?php

namespace app\Web\Middleware;

class ValidateRequest
{
    public static function validate(array $rules)
    {
        $validationErrors = [];

        foreach ($rules as $field => $rule) {
            // Check if the field is required
            if (strpos($rule, 'required') !== false) {
                if (!isset($_POST[$field]) || empty($_POST[$field])) {
                    // Field is missing or empty, add validation error
                    $validationErrors[$field] = "The field '{$field}' is required.";
                }
            }

            // Implement other validation rules as per your requirements
            // You can use regular expressions or other validation techniques

            // Example rule: Email validation
            if (strpos($rule, 'email') !== false) {
                $email = filter_input(INPUT_POST, $field, FILTER_VALIDATE_EMAIL);
                if ($email === false) {
                    // Invalid email format, add validation error
                    $validationErrors[$field] = "Invalid email format for field '{$field}'.";
                }
            }
        }

        if (!empty($validationErrors)) {
            // Validation errors occurred, store the errors in the session
            $_SESSION['validation_errors'] = $validationErrors;
        
            // Redirect back to the registration page
            header('Location: /api/register');
            exit();
        }
        
        header('Location: /Success');
        exit();
        // All validations passed, continue with the registration process
    }
}

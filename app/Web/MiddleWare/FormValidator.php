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

namespace app\Web\Middleware;

use Config\Database;

class FormValidator
{
    public function validate(array $rules)
    {
        $validationErrors = [];

        foreach ($rules as $field => $rule) {
            // Check if the field is required
            if (strpos($rule, 'required') !== false) {
                if (!isset($_POST[$field]) || empty($_POST[$field])) {
                    // Field is missing or empty, add validation error
                    $validationErrors[] = "The field '{$field}' is required.";
                }
            }

            // Email validation
            if ($field === 'email' && strpos($rule, 'email') !== false) {
                $email = filter_input(INPUT_POST, $field, FILTER_VALIDATE_EMAIL);
                if ($email === false) {
                    // Invalid email format, add validation error
                    $validationErrors[] = "Invalid email format for field '{$field}'.";
                }
            }

            // Check if username or email already exists in the database
            if ($field === 'username' || $field === 'email') {
                if (strpos($rule, 'unique') !== false) {
                    $value = $_POST[$field];
                    $database = Database::getInstance()->getConnection();

                    // Check if the username or email already exists in the database
                    $query = "SELECT * FROM pulse_users WHERE {$field} = :value";
                    $statement = $database->prepare($query);
                    $statement->bindValue(':value', $value);
                    $statement->execute();
                    $result = $statement->fetch();

                    if ($result) {
                        // Username or email already exists, add validation error
                        $validationErrors[] = "The {$field} '{$value}' already exists.";
                    }
                }
            }
        }

        return $validationErrors;
    }
}

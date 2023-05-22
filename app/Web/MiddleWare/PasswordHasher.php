<?php

namespace app\Web\Middleware;

class PasswordHasher
{
    public static function hashPassword($password)
    {
        // Implement your password hashing logic here
        // Example: Using the password_hash() function to hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        return $hashedPassword;
    }
}

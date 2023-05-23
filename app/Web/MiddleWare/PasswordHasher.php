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

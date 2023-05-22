<?php

namespace app\Web\Middleware;

class EncryptData
{
    public static function encrypt($data)
    {
        // Implement your encryption logic here
        // Example: Using the password_hash() function to encrypt the data
        $encryptedData = password_hash($data, PASSWORD_DEFAULT);

        return $encryptedData;
    }
}

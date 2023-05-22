<?php
namespace app\Web\Middleware;


class handleSuccess
{
    public function handleSuccess($role)
    {
        // Redirect the user based on their role
        if ($role === 'admin') {
            header('Location: /Success');
        } elseif ($role === 'user') {
            header('Location: /Failed');
        } elseif ($role === 'superadmin') {
            header('Location: /Warning');
        }

        // Store the CSRF token in the session for future requests
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        exit();
    }
}



<?php

namespace app\Web\Middleware;

use app\API\Controllers\AuthController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationMiddleware
{
    public function handle(Request $request): ?Response
    {
        // Check if the user is authenticated
        if (!AuthController::isAuthenticated()) {
            // User is not authenticated, redirect to the login page
            header('Location: /login');
            exit();
        }

        // Check if the user has the required role for the current route
        if (!AuthController::hasRole($requiredRole)) {
            // User does not have the required role, show an access denied page or redirect to a specific route
            header('Location: /access-denied');
            exit();
        }

        // User is authenticated and has the required role, allow the request to proceed
        return null;
    }
}

<?php
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/API/Controllers/HomeController.php';
require_once __DIR__ . '/app/API/Controllers/AuthController.php';

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpFoundation\Request;

$routes = new RouteCollection();

$routes->add('home', new Route('/', [
    '_controller' => 'app\\API\\Controllers\\HomeController::index',
]));

$routes->add('login', new Route('/api/login', [
    '_controller' => 'app\\API\\Controllers\\AuthController::login',
], [], [], '', [], ['POST']));

$routes->add('register', new Route('/api/register', [
    '_controller' => 'app\\API\\Controllers\\AuthController::register',
], [], [], '', [], ['POST']));

$routes->add('logout', new Route('/api/logout', [
    '_controller' => 'app\\API\\Controllers\\AuthController::logout',
]));

$context = new RequestContext();
$context->fromRequest(Request::createFromGlobals());

$matcher = new UrlMatcher($routes, $context);

$request = Request::createFromGlobals();

try {
    $parameters = $matcher->match($request->getPathInfo());
    $controller = $parameters['_controller'];
    [$class, $method] = explode('::', $controller);
    $response = call_user_func([$class, $method]);
    echo $response;
} catch (ResourceNotFoundException $e) {
    echo '404 - Not Found';
}

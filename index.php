<?php
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/API/Controllers/HomeController.php';
require_once __DIR__ . '/app/API/Controllers/AuthController.php';

//test controller requires
require_once __DIR__ . '/tests/API/Controllers/AuthControllerTest.php';



use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpFoundation\Request;

$routes = new RouteCollection();
//please add your test routing here before sending to the main route in app please
//test routine
//example
$routes->add('Test Auth', new Route('/TestAuth', [
    '_controller' => 'tests\\API\\Controllers\\AuthControllerTest::login',
]));





//test ends here thanks 
// general routes for all platforms such as web,android and desktop apps
$routes->add('home', new Route('/', [
    '_controller' => 'App\\API\\Controllers\\HomeController::index',
]));

$routes->add('login', new Route('/api/login', [
    '_controller' => 'App\\API\\Controllers\\AuthController::login',
], [], [], '', [], ['POST']));

$routes->add('register', new Route('/api/register', [
    '_controller' => 'App\\API\\Controllers\\AuthController::register',
], [], [], '', [], ['POST']));

$routes->add('logout', new Route('/api/logout', [
    '_controller' => 'App\\API\\Controllers\\AuthController::logout',
]));
$routes->add('comment', new Route('/api/comment', [
    '_controller' => 'App\\API\\Controllers\\CommentController::create',
], [], [], '', [], ['POST']));

$routes->add('share', new Route('/api/share', [
    '_controller' => 'App\\API\\Controllers\\ShareController::create',
], [], [], '', [], ['POST']));

$routes->add('message', new Route('/api/message', [
    '_controller' => 'App\\API\\Controllers\\MessageController::create',
], [], [], '', [], ['POST']));

$routes->add('subscription', new Route('/api/subscription', [
    '_controller' => 'App\\API\\Controllers\\SubscriptionController::subscribe',
], [], [], '', [], ['POST']));

$routes->add('get_messages', new Route('/api/messages', [
    '_controller' => 'App\\API\\Controllers\\MessageController::index',
], [], [], '', [], ['GET']));

$routes->add('get_subscriptions', new Route('/api/subscriptions', [
    '_controller' => 'App\\API\\Controllers\\SubscriptionController::index',
], [], [], '', [], ['GET']));


//web specific routes starts here




//web specific routes ends


//mobile specific routes starts




//mobile specific routes ends




//desktop specific routes strnatcasecmp





//desktop specific routes ends
$context = new RequestContext('./');
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

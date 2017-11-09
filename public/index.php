<?php

use Equip\Dispatch\MiddlewareCollection;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Middlewares\Utils\CallableResolver\ContainerResolver;
use Middlewares\Utils\Factory;
use Psr\Container\ContainerInterface;
use Symfony\Component\Dotenv\Dotenv;
use Zend\Diactoros\Response\SapiStreamEmitter;
use Zend\Diactoros\ServerRequestFactory;

require __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv())->load(__DIR__.'/../.env');
} catch (\Exception $e) {
}

call_user_func(function () {
    /** @var ContainerInterface $container */
    $container = require __DIR__.'/../config/container.php';
    $routes = require __DIR__.'/../config/routes.php';
    $middleware = require __DIR__.'/../config/middleware.php';

    // Add our routing and response middleware
    $middleware[] = new FastRoute($routes);
    $middleware[] = new RequestHandler(new ContainerResolver($container));

    $dispatcher = new MiddlewareCollection($middleware);

    $request = ServerRequestFactory::fromGlobals();
    $response = $dispatcher->dispatch($request, function () {
        // We never expect this to happen, but just in case
        return Factory::createResponse(404);
    });

    (new SapiStreamEmitter())->emit($response);
});

<?php

use Equip\Dispatch\MiddlewareCollection;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Middlewares\Utils\CallableResolver\ContainerResolver;
use Middlewares\Utils\Factory;
use Middlewares\Whoops;
use Psr\Container\ContainerInterface;
use Zend\Diactoros\Response\SapiStreamEmitter;
use Zend\Diactoros\ServerRequestFactory;

require __DIR__ . '/../vendor/autoload.php';

call_user_func(function () {
    /** @var ContainerInterface $container */
    $container = require __DIR__.'/../config/container.php';
    $routes = require __DIR__.'/../config/routes.php';

    $middleware = [
        new Whoops(),
        new FastRoute($routes),
        new RequestHandler(new ContainerResolver($container)),
    ];

    $collection = new MiddlewareCollection($middleware);

    $request = ServerRequestFactory::fromGlobals();
    $response = $collection->dispatch($request, function () {
        // We never expect this to happen, but just in case
        return Factory::createResponse(404);
    });

    (new SapiStreamEmitter())->emit($response);
});

<?php

use App\Action\HomepageAction;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\TextResponse;

return FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $route) {
    $route->get('/', HomepageAction::class);

    $route->get('/hello/{name}', function (ServerRequestInterface $request) {
        return new TextResponse(sprintf('Hello %s', $request->getAttribute('name')));
    });

    $route->get('/error', function () {
        throw new RuntimeException('This is an unhandled exception.');
    });
});

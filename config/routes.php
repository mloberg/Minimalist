<?php

return FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $route) {
    $route->get('/', \App\Controller\HomepageController::class);

    $route->get('/hello/{name}', function (\Psr\Http\Message\ServerRequestInterface $request) {
        return new \Zend\Diactoros\Response\TextResponse(sprintf('Hello %s', $request->getAttribute('name')));
    });

    $route->get('/error', function () {
        throw new \RuntimeException('This is an unhandled exception.');
    });
});

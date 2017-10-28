<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

$container = new ContainerBuilder();

$container->register(\App\Greeter::class);
$container
    ->register(\App\Action\HomepageAction::class)
    ->addArgument(new Reference(\App\Greeter::class));

$container->compile();

return $container;

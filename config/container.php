<?php

use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$isDebug = (bool) env('APP_DEBUG');

$file = __DIR__.'/../var/cache/container.php';
$containerConfigCache = new ConfigCache($file, $isDebug);

if (!$containerConfigCache->isFresh()) {
    $container = new ContainerBuilder();
    $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
    $loader->load('services.yaml');

    $container->compile();

    $dumper = new PhpDumper($container);
    $containerConfigCache->write(
        $dumper->dump(),
        $container->getResources()
    );
}

require_once $file;

return new ProjectServiceContainer();

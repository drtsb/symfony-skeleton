<?php

declare(strict_types=1);

namespace App;

use Redis;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\RedisSessionHandler;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('../config/{packages}/*.php');
        $container->import("../config/{packages}/{$this->environment}/*.php");
        $container->import('./**/{di}.php');
        $container->import("./**/{di}_{$this->environment}.php");
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import("../config/{routes}/{$this->environment}/*.php");
        $routes->import('../config/{routes}/*.php');
        $routes->import("./**/{routing}_{$this->environment}.php");
        $routes->import('./**/{routing}.php');
    }

    protected function build(ContainerBuilder $container): void
    {
        $container
            ->register('Redis', Redis::class)
            ->addMethodCall('connect', ['%env(REDIS_HOST)%', /*'%env(int:REDIS_PORT)%'*/])
            ->addMethodCall('auth', ['%env(REDIS_PASSWORD)%']);

        $container
            ->register(RedisSessionHandler::class)
            ->addArgument(
                new Reference('Redis'),
                // you can optionally pass an array of options. The only option is 'prefix',
                // which defines the prefix to use for the keys to avoid collision on the Redis server:
                // ['prefix' => 'my_prefix'],
            );
    }
}

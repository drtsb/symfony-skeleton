<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/doctrine/');

    $containerConfigurator->extension(
        'doctrine',
        [
            'dbal' => [
                'url'            => '%env(resolve:DATABASE_URL)%',
                'server_version' => '%env(resolve:DATABASE_VERSION)%',
                'driver'         => 'pdo_pgsql',
                'charset'        => 'utf8',
            ],
            'orm'  => [
                'connection'                  => 'default',
                'auto_generate_proxy_classes' => true,
                'naming_strategy'             => 'doctrine.orm.naming_strategy.underscore_number_aware',
                'auto_mapping'                => true,
            ],
        ]
    );
};

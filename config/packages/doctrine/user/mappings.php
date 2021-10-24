<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension(
        'doctrine',
        [
            'orm' => [
                'mappings' => [
                    'User' => [
                        'type'   => 'xml',
                        'dir'    => '%kernel.project_dir%/src/User/Infrastructure/Persistence/Doctrine/Mapping/User',
                        'prefix' => 'App\User\Domain\Aggregate\User',
                        'alias'  => 'User',
                    ],
                ],
            ],
        ],
    );
};

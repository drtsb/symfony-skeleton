<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension(
        'doctrine_migrations',
        [
            'all_or_nothing'   => true,
            'migrations_paths' => [
                'App\Shared\Infrastructure\Persistence\Doctrine\Migration'
                => '%kernel.project_dir%/src/Shared/Infrastructure/Persistence/Doctrine/Migration',
            ],
        ]
    );
};

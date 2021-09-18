<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension(
        'framework',
        [
            'messenger' => [
                'transports'  => null,
                'default_bus' => 'command.bus',
                'buses'       => [
                    'command.bus' => null,
                    'query.bus'   => null,
                    'event.bus'   => ['default_middleware' => 'allow_no_handlers'],
                ],
                'routing'     => null,
            ],
        ]
    );
};

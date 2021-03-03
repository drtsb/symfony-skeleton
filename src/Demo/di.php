<?php

declare(strict_types=1);

namespace App\Shared;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $di): void {
    $services = $di->services();

    $services->load('App\Demo\UI\Controller\\', 'UI/Controller')
        ->tag('controller.service_arguments');
};

<?php

declare(strict_types=1);

namespace App\Demo;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $di): void {
    $services = $di
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
    ;

    $services->load('App\Demo\UI\Controller\\', 'UI/Controller')
        ->tag('controller.service_arguments');
};

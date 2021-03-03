<?php

declare(strict_types=1);

namespace App\Shared;

use App\Shared\Infrastructure\Metric\MetricInterface;
use App\Shared\Infrastructure\Metric\PrometheusGenerator;
use App\Shared\UI\Command\Init\InitAllCommand;
use App\Shared\UI\Command\Init\InitCommand;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $di): void {
    $services = $di
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
    ;

    $services->load('App\\', '../../src/*')
        ->exclude(
            [
                '../{Kernel.php}',
            ]
        );

    $services->load('App\Shared\UI\Controller\\', 'UI/Controller')
        ->tag('controller.service_arguments');

    $services
        ->instanceof(InitCommand::class)
        ->tag('app.console.command.init');

    $services
        ->instanceof(MetricInterface::class)
        ->tag('app.metric');

    $services->set(InitAllCommand::class)
        ->args([tagged_iterator('app.console.command.init')]);

    $services->set(PrometheusGenerator::class)
        ->args([tagged_iterator('app.metric')]);
};

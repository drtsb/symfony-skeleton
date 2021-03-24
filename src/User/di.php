<?php

declare(strict_types=1);

namespace App\Shared;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $di): void {
    $services = $di
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
    ;

    $services->load('App\User\UI\Controller\\', 'UI/Controller')
        ->tag('controller.service_arguments');

    $services->load('App\User\Application\Command\\', 'Application/Command/**/*CommandHandler.php')
        ->autoconfigure(false)
        ->tag('messenger.message_handler', ['bus' => 'command.bus']);

    $services->load('App\User\Application\Event\\', 'Application/Event/**/*EventHandler.php')
        ->autoconfigure(false)
        ->tag('messenger.message_handler', ['bus' => 'event.bus']);

    $services->load('App\User\Application\Query\\', 'Application/Query/**/*QueryHandler.php')
        ->autoconfigure(false)
        ->tag('messenger.message_handler', ['bus' => 'query.bus']);
};

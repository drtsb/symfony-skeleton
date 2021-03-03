<?php

declare(strict_types=1);

namespace App\Shared;

use App\Shared\Infrastructure\Persistence\Doctrine\FixPostgreSQLDefaultSchemaListener;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $di): void {
    $services = $di->services();

    $services
        ->set(FixPostgreSQLDefaultSchemaListener::class)
        ->tag('doctrine.event_listener', ['event' => 'postGenerateSchema']);
};

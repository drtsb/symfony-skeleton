<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator->import('../../src/Shared/UI/Controller/', 'annotation');

    $routingConfigurator->import('../../src/Kernel.php', 'annotation');

    $routingConfigurator->import('../../src/Demo/UI/Controller/', 'annotation');

    $routingConfigurator->import('../../src/User/UI/Controller/', 'annotation');
};

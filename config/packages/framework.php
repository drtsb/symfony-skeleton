<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\RedisSessionHandler;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension(
        'framework',
        [
            'secret'     => '%env(APP_SECRET)%',
            'session'    => [
                'enabled'         => true,
                'handler_id'      => RedisSessionHandler::class,
                'cookie_secure'   => 'auto',
                'cookie_samesite' => 'lax',
            ],
            'php_errors' => ['log' => true],
        ],
    );
};

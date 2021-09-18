<?php

declare(strict_types=1);

use App\Shared\Infrastructure\Security\LoginFormAuthenticator;
use App\Shared\Infrastructure\Security\UserProvider;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension(
        'security',
        [
            'providers'      => ['app_user_provider' => ['id' => UserProvider::class]],
            'firewalls'      => [
                'dev'  => [
                    'pattern'  => '^/(_(profiler|wdt)|css|images|js)/',
                    'security' => false,
                ],
                'main' => [
                    'anonymous'   => true,
                    'stateless'   => false,
                    'form_login'  => [
                        'login_path'  => 'security.login',
                        'check_path'  => 'security.login',
                        'use_referer' => true,
                    ],
                    'guard'       => ['authenticators' => [LoginFormAuthenticator::class]],
                    'remember_me' => [
                        'secret'   => '%kernel.secret%',
                        'lifetime' => 604800,
                    ],
                    'logout'      => [
                        'path'   => 'security.logout',
                        'target' => 'home',
                    ],
                ],
            ],
            'access_control' => [
                [
                    'path'  => '^/$',
                    'roles' => 'IS_AUTHENTICATED_ANONYMOUSLY',
                ],
                ['path' => '^/metrics', 'roles' => 'IS_AUTHENTICATED_ANONYMOUSLY'],
                ['path' => '^/security', 'roles' => 'IS_AUTHENTICATED_ANONYMOUSLY'],
                ['path' => '^/user', 'roles' => 'ROLE_ADMIN'],
                ['path' => '^/', 'roles' => 'ROLE_USER'],
            ],
        ]
    );
};

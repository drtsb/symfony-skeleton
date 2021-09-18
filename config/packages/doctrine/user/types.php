<?php

declare(strict_types=1);

use App\User\Infrastructure\Persistence\Doctrine\Mapping\User\UserRolesType;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('doctrine', ['dbal' => ['types' => ['user_user_roles' => UserRolesType::class]]]);
};

<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Adapter\User;

use App\Shared\Infrastructure\Adapter\User\Dto\UserAuthenticationDto;

interface UserAdapterInterface
{
    public function findUserForAuthentication(string $email): ?UserAuthenticationDto;
}

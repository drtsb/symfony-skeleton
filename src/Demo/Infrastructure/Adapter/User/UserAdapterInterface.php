<?php

declare(strict_types=1);

namespace App\Demo\Infrastructure\Adapter\User;

use App\Demo\Infrastructure\Adapter\User\Dto\UserDto;

interface UserAdapterInterface
{
    /**
     * @return UserDto[]
     */
    public function findActiveUsers(): array;
}

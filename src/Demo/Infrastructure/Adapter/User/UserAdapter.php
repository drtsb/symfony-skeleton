<?php

declare(strict_types=1);

namespace App\Demo\Infrastructure\Adapter\User;

use App\Demo\Infrastructure\Adapter\User\Dto\UserDto;
use App\User\Api\UserApiInterface;

final class UserAdapter implements UserAdapterInterface
{
    public function __construct(private UserApiInterface $api)
    {
    }

    /**
     * @return UserDto[]
     */
    public function findActiveUsers(): array
    {
        $result = [];

        foreach ($this->api->findActiveUsers() as $user) {
            $result[] = UserDto::createFromOriginalDto($user);
        }

        return $result;
    }
}

<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Adapter\User;

use App\Shared\Infrastructure\Adapter\User\Dto\UserAuthenticationDto;
use App\User\Api\UserApiInterface;

final class UserAdapter implements UserAdapterInterface
{
    public function __construct(private UserApiInterface $api)
    {
    }

    public function findUserForAuthentication(string $email): ?UserAuthenticationDto
    {
        $userDto = $this->api->findActiveUserByEmail($email);

        return $userDto->id !== null ? UserAuthenticationDto::createFromOriginalDto($userDto) : null;
    }
}

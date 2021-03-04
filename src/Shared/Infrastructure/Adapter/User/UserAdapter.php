<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Adapter\User;

use App\User\Api\UserApiInterface;
use App\Shared\Infrastructure\Adapter\User\Dto\UserAuthenticationDto;

final class UserAdapter implements UserAdapterInterface
{
    private UserApiInterface $api;

    public function __construct(UserApiInterface $api)
    {
        $this->api = $api;
    }

    public function findUserForAuthentication(string $email): ?UserAuthenticationDto
    {
        $userDto = $this->api->findActiveUserByEmail($email);

        return $userDto->id !== null ? UserAuthenticationDto::createFromOriginalDto($userDto) : null;
    }
}

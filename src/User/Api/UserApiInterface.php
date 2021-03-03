<?php

declare(strict_types=1);

namespace App\User\Api;

use App\User\Api\Dto\UserDto;
use InvalidArgumentException;

interface UserApiInterface
{
    /**
     * @param string $email
     * @return UserDto
     * @throws InvalidArgumentException
     */
    public function findActiveUserByEmail(string $email): UserDto;

    /**
     * @return UserDto[]
     */
    public function findActiveUsers(): array;
}

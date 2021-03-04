<?php

declare(strict_types=1);

namespace App\User\Api;

use App\User\Api\Dto\UserDto;
use App\User\Domain\Aggregate\User\User;
use App\User\Domain\Repository\UserRepositoryInterface;

final class UserApi implements UserApiInterface
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    /**
     * @param string $email
     * @return UserDto
     */
    public function findActiveUserByEmail(string $email): UserDto
    {
        $user = $this->repository->findActiveUserByEmail($email);

        return $user !== null ? UserDto::createFromUser($user) : new UserDto();
    }

    /**
     * @return UserDto[]
     */
    public function findActiveUsers(): array
    {
        $dto = [];

        /** @var User $user */
        foreach ($this->repository->findAllActiveUsers() as $user) {
            $dto[] = UserDto::createFromUser($user);
        }

        return $dto;
    }
}

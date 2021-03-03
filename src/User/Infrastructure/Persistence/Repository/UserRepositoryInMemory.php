<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Persistence\Repository;

use App\User\Domain\Aggregate\User\User;
use App\User\Domain\Exception\User\UserAlreadyExistsException;
use App\User\Domain\Repository\UserRepositoryInterface;
use Exception;
use InvalidArgumentException;

final class UserRepositoryInMemory
{
    private array $users = [
        [
            'id'            => '068e6855-d0d6-4cb1-bb9d-35f29bea997f',
            'email'         => 'test@test.com',
            'passwordHash'  => '$2y$10$z3CjZKMMUzs5U90NWbLRCOt6FRqya5suukfqLnvvsuHfonJtl0K8G', // qwerty
            'lastLoginTime' => '2020-11-08 15:23:45',
        ],
    ];

    /**
     * @param string $email
     * @return User|null
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function findUserByEmail(string $email): ?User
    {
        $userEntity = null;
/*        foreach ($this->users as $existingUser) {
            if ($existingUser['email'] === $email) {
                $userEntity = User::create(
                    UserEmail::create($existingUser['email']),
                    UserPasswordHash::create($existingUser['passwordHash']),
                    Uuid::create($existingUser['id']),
                    $existingUser['lastLoginTime'] !== null ?
                        new DateTimeImmutable($existingUser['lastLoginTime']) :
                        null
                );
            }
        }*/

        return $userEntity;
    }

    /**
     * @param User $user
     * @throws UserAlreadyExistsException
     */
    public function add(User $user): void
    {
        foreach ($this->users as $existingUser) {
            if ($existingUser['id'] === (string)$user->getId()) {
                throw new UserAlreadyExistsException(sprintf('User with id `%s` already exists.', $existingUser['id']));
            }
            if ($existingUser['email'] === (string)$user->getEmail()) {
                throw new UserAlreadyExistsException(
                    sprintf('User with email `%s` already exists.', $existingUser['email'])
                );
            }
        }

        $this->users[] = [
            'id'            => (string)$user->getId(),
            'email'         => (string)$user->getEmail(),
            'passwordHash'  => (string)$user->getPasswordHash(),
            'lastLoginTime' => $user->getLastLoginTime() !== null ?
                $user->getLastLoginTime()->format('Y-m-d H:i:s') :
                null,
        ];
    }

    public function findAll(): array
    {
        return [];
    }
}

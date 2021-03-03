<?php

declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\User\Domain\Aggregate\User\User;
use App\User\Domain\Exception\User\UserAlreadyExistsException;
use App\Shared\Domain\Exception\EntityNotAddedException;
use App\Shared\Domain\Exception\EntityNotFoundException;

interface UserRepositoryInterface
{
    public function findAll(): array;

    public function findAllActiveUsers(): array;

    public function findActiveUserByEmail(string $email): ?User;

    /**
     * @param string $id
     * @return User
     * @throws EntityNotFoundException
     */
    public function getById(string $id): User;

    /**
     * @param string $email
     * @return User
     * @throws EntityNotFoundException
     */
    public function getByEmail(string $email): User;

    /**
     * @param User $user
     * @throws EntityNotAddedException
     * @throws UserAlreadyExistsException
     */
    public function add(User $user): void;
}

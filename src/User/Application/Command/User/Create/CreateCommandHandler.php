<?php

declare(strict_types=1);

namespace App\User\Application\Command\User\Create;

use App\User\Domain\Aggregate\User\User;
use App\User\Domain\Aggregate\User\UserEmail;
use App\User\Domain\Aggregate\User\UserPasswordHash;
use App\User\Domain\Exception\User\UserAlreadyExistsException;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Domain\Exception\EntityNotAddedException;
use App\Shared\Infrastructure\MessageBus\CommandHandlerInterface;
use InvalidArgumentException;

final class CreateCommandHandler implements CommandHandlerInterface
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    /**
     * @param CreateCommand $command
     * @throws InvalidArgumentException
     * @throws UserAlreadyExistsException
     * @throws EntityNotAddedException
     */
    public function __invoke(CreateCommand $command): void
    {
        $user = User::create(
            UserEmail::create($command->email),
            UserPasswordHash::create(password_hash($command->password, PASSWORD_BCRYPT))
        );
        $user->setRoles($command->roles);

        $this->repository->add($user);
    }
}

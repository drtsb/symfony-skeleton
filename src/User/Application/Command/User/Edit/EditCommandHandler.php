<?php

declare(strict_types=1);

namespace App\User\Application\Command\User\Edit;

use App\Shared\Domain\Exception\EntityNotFoundException;
use App\Shared\Infrastructure\MessageBus\CommandHandlerInterface;
use App\User\Domain\Aggregate\User\UserEmail;
use App\User\Domain\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;

final class EditCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param EditCommand $command
     * @throws InvalidArgumentException
     * @throws EntityNotFoundException
     */
    public function __invoke(EditCommand $command): void
    {
        $this->repository->getById($command->id)
            ->setEmail(UserEmail::create($command->email))
            ->setRoles($command->roles);

        $this->entityManager->flush();
    }
}

<?php

declare(strict_types=1);

namespace App\User\Application\Command\User\Delete;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Domain\Exception\EntityNotFoundException;
use App\Shared\Infrastructure\MessageBus\CommandHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

final class DeleteCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @param DeleteCommand $command
     * @throws EntityNotFoundException
     */
    public function __invoke(DeleteCommand $command): void
    {
        $user = $this->repository->getById($command->id);

        $this->entityManager->remove($user);

        $this->entityManager->flush();
    }
}

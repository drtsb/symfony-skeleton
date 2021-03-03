<?php

declare(strict_types=1);

namespace App\User\Application\User\Command\Unban;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Domain\Exception\EntityNotFoundException;
use App\Shared\Infrastructure\MessageBus\CommandHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

final class UnbanCommandHandler implements CommandHandlerInterface
{
    private UserRepositoryInterface $repository;

    private EntityManagerInterface $entityManager;

    public function __construct(UserRepositoryInterface $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param UnbanCommand $command
     * @throws EntityNotFoundException
     */
    public function __invoke(UnbanCommand $command): void
    {
        $this->repository->getById($command->getId())->unban();

        $this->entityManager->flush();
    }
}

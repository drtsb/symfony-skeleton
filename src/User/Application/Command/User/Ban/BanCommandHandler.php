<?php

declare(strict_types=1);

namespace App\User\Application\Command\User\Ban;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Domain\Exception\EntityNotFoundException;
use App\Shared\Infrastructure\MessageBus\CommandHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

final class BanCommandHandler implements CommandHandlerInterface
{
    public function __construct(private UserRepositoryInterface $repository, private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param BanCommand $command
     * @throws EntityNotFoundException
     */
    public function __invoke(BanCommand $command): void
    {
        $this->repository->getById($command->getId())->ban();

        $this->entityManager->flush();
    }
}

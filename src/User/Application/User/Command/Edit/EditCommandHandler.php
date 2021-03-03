<?php

declare(strict_types=1);

namespace App\User\Application\User\Command\Edit;

use App\User\Domain\Aggregate\User\UserEmail;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Domain\Exception\EntityNotFoundException;
use App\Shared\Infrastructure\MessageBus\CommandHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;

final class EditCommandHandler implements CommandHandlerInterface
{
    private UserRepositoryInterface $repository;

    private EntityManagerInterface $entityManager;

    public function __construct(UserRepositoryInterface $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
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

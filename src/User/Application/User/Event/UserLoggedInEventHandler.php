<?php

declare(strict_types=1);

namespace App\User\Application\User\Event;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Domain\Event\User\UserLoggedInEvent;
use App\Shared\Infrastructure\MessageBus\EventHandlerInterface;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

final class UserLoggedInEventHandler implements EventHandlerInterface
{
    private UserRepositoryInterface $userRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(UserRepositoryInterface $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param UserLoggedInEvent $event
     * @throws Exception
     */
    public function __invoke(UserLoggedInEvent $event)
    {
        $user = $this->userRepository->getByEmail($event->getEmail());

        $user->setLastLoginTime(new DateTimeImmutable($event->getTime()));

        $this->entityManager->flush();
    }
}

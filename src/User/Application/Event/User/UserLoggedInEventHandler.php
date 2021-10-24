<?php

declare(strict_types=1);

namespace App\User\Application\Event\User;

use App\Shared\Domain\Event\User\UserLoggedInEvent;
use App\Shared\Infrastructure\MessageBus\EventHandlerInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

final class UserLoggedInEventHandler implements EventHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private EntityManagerInterface $entityManager,
    ) {
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

<?php

declare(strict_types=1);

namespace App\User\Application\User\Query\Show;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Domain\Exception\EntityNotFoundException;
use App\Shared\Infrastructure\MessageBus\QueryHandlerInterface;

final class ShowQueryHandler implements QueryHandlerInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    /**
     * @param ShowQuery $query
     * @return ShowQueryDto
     * @throws EntityNotFoundException
     */
    public function __invoke(ShowQuery $query): ShowQueryDto
    {
        $user = $this->userRepository->getById($query->id);

        return ShowQueryDto::createFromUser($user);
    }
}

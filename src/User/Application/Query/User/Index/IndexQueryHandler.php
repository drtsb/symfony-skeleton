<?php

declare(strict_types=1);

namespace App\User\Application\Query\User\Index;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Infrastructure\MessageBus\QueryHandlerInterface;

final class IndexQueryHandler implements QueryHandlerInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(IndexQuery $query): IndexQueryDto
    {
        $usersDto = [];

        foreach ($this->userRepository->findAll() as $user) {
            $usersDto[] = UserDto::createFromUser($user);
        }

        return new IndexQueryDto(['users' => $usersDto]);
    }
}

<?php

declare(strict_types=1);

namespace App\User\Application\User\Query\Index;

use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Infrastructure\MessageBus\QueryHandlerInterface;

final class IndexQueryHandler implements QueryHandlerInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
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

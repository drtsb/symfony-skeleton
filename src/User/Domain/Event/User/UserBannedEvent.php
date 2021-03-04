<?php

declare(strict_types=1);

namespace App\User\Domain\Event\User;

use App\User\Domain\Aggregate\User\User;
use App\Shared\Domain\Event\DomainEventInterface;

final class UserBannedEvent implements DomainEventInterface
{
    private function __construct(public string $userId)
    {
    }

    public static function create(User $user): self
    {
        return new self($user->getId()->getValue());
    }
}

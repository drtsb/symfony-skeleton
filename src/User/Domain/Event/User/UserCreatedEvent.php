<?php

declare(strict_types=1);

namespace App\User\Domain\Event\User;

use App\Shared\Domain\Event\DomainEventInterface;

final class UserCreatedEvent implements DomainEventInterface
{
    public string $id;

    public string $email;

    public string $passwordHash;

    public array $roles;
}

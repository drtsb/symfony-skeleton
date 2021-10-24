<?php

declare(strict_types=1);

namespace App\User\Application\Query\User\Index;

use App\User\Domain\Aggregate\User\User;
use DateTimeInterface;
use Spatie\DataTransferObject\DataTransferObject;

final class UserDto extends DataTransferObject
{
    public string $id;

    public DateTimeInterface $createdAt;

    public string $email;

    public array $roles;

    public string $status;

    public static function createFromUser(User $user): self
    {
        return new self(
            [
                'id'        => $user->getId()->getValue(),
                'email'     => $user->getEmail()->getValue(),
                'createdAt' => $user->getCreatedAt(),
                'status'    => $user->getStatus()->getValue(),
                'roles'     => $user->getRoles(),
            ],
        );
    }
}

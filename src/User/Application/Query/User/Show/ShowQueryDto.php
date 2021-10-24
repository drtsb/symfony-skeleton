<?php

declare(strict_types=1);

namespace App\User\Application\Query\User\Show;

use App\User\Domain\Aggregate\User\User;
use DateTimeInterface;
use Spatie\DataTransferObject\DataTransferObject;

final class ShowQueryDto extends DataTransferObject
{
    public string $id;

    public string $email;

    public DateTimeInterface $createdAt;

    public string $status;

    public bool $isBanned;

    public array $roles;

    public ?DateTimeInterface $lastLoginTime = null;

    public static function createFromUser(User $user): self
    {
        return new self(
            [
                'id'            => $user->getId()->getValue(),
                'email'         => $user->getEmail()->getValue(),
                'createdAt'     => $user->getCreatedAt(),
                'status'        => $user->getStatus()->getValue(),
                'isBanned'      => $user->isBanned(),
                'roles'         => $user->getRoles(),
                'lastLoginTime' => $user->getLastLoginTime(),
            ],
        );
    }
}

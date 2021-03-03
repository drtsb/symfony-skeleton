<?php

declare(strict_types=1);

namespace App\User\Api\Dto;

use App\User\Domain\Aggregate\User\User;
use Spatie\DataTransferObject\DataTransferObject;

final class UserDto extends DataTransferObject
{
    private const DATE_FORMAT = 'Y-m-d H:i:s';

    public ?string $id = null;

    public ?string $email = null;

    public ?string $passwordHash = null;

    public ?array $roles = null;

    public ?string $lastLoginTime = null;

    public static function createFromUser(User $user): self
    {
        return new self(
            [
                'id'            => (string)$user->getId(),
                'email'         => (string)$user->getEmail(),
                'passwordHash'  => (string)$user->getPasswordHash(),
                'roles'         => array_map(
                    static function ($value) {
                        return (string)$value;
                    },
                    $user->getRoles()
                ),
                'lastLoginTime' => $user->getLastLoginTime() ?
                    $user->getLastLoginTime()->format(self::DATE_FORMAT) :
                    null,
            ]
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Adapter\User\Dto;

use App\User\Api\Dto\UserDto;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Spatie\DataTransferObject\DataTransferObject;

final class UserAuthenticationDto extends DataTransferObject
{
    public UuidInterface $id;

    public string $email;

    public string $passwordHash;

    public array $roles;

    public static function createFromOriginalDto(UserDto $dto): self
    {
        return new self(
            [
                'id'           => Uuid::fromString($dto->id),
                'email'        => $dto->email,
                'passwordHash' => $dto->passwordHash,
                'roles'        => $dto->roles,
            ],
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Demo\Infrastructure\Adapter\User\Dto;

use App\User\Api\Dto\UserDto as OriginalDto;
use Spatie\DataTransferObject\DataTransferObject;

final class UserDto extends DataTransferObject
{
    public string $email;

    public static function createFromOriginalDto(OriginalDto $dto): self
    {
        return new self(
            [
                'email' => $dto->email,
            ]
        );
    }
}

<?php

declare(strict_types=1);

namespace App\User\Domain\Aggregate\User;

use App\Shared\Domain\ValueObject\StringValueObject;

final class UserPasswordHash extends StringValueObject
{
    private function __construct(string $hash)
    {
        $this->value = $hash;
    }

    public static function create(string $hash): self
    {
        return new self($hash);
    }
}

<?php

declare(strict_types=1);

namespace App\User\Domain\Aggregate\User;

use App\Shared\Domain\ValueObject\StringValueObject;
use InvalidArgumentException;

final class UserStatus extends StringValueObject
{
    public const ACTIVE = 'active';
    public const BANNED = 'banned';

    public const VALUES = [
        self::ACTIVE,
        self::BANNED,
    ];

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @param string $status
     * @return UserStatus
     * @throws InvalidArgumentException
     */
    public static function create(string $status): self
    {
        if (!in_array($status, self::VALUES, true)) {
            /** @noinspection JsonEncodingApiUsageInspection */
            throw new InvalidArgumentException(
                sprintf(
                    'UserStatus should be one of %s, `%s` provided.',
                    json_encode(self::VALUES),
                    $status,
                ),
            );
        }

        return new self($status);
    }

    public static function active(): self
    {
        return new self(self::ACTIVE);
    }

    public static function banned(): self
    {
        return new self(self::BANNED);
    }
}

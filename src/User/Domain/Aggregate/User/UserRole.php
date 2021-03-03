<?php

declare(strict_types=1);

namespace App\User\Domain\Aggregate\User;

use App\Shared\Domain\ValueObject\StringValueObject;
use InvalidArgumentException;
use JsonSerializable;

final class UserRole extends StringValueObject implements JsonSerializable
{
    public const ROLE_USER  = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    public const VALUES = [
        self::ROLE_USER,
        self::ROLE_ADMIN,
    ];

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @param string $role
     * @return UserRole
     * @throws InvalidArgumentException
     */
    public static function create(string $role): self
    {
        if (!in_array($role, self::VALUES)) {
            /** @noinspection JsonEncodingApiUsageInspection */
            throw new InvalidArgumentException(
                sprintf(
                    'UserRole should be one of %s, `%s` provided.',
                    json_encode(self::VALUES),
                    $role
                )
            );
        }
        return new self($role);
    }

    public static function user(): self
    {
        return new self(self::ROLE_USER);
    }

    public static function admin(): self
    {
        return new self(self::ROLE_ADMIN);
    }

    public function jsonSerialize()
    {
        return $this->value;
    }
}

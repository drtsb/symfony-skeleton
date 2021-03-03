<?php

declare(strict_types=1);

namespace App\User\Domain\Aggregate\User;

use App\Shared\Domain\ValueObject\StringValueObject;
use InvalidArgumentException;

final class UserEmail extends StringValueObject
{
    /**
     * UserEmail constructor.
     * @param string $email
     * @throws InvalidArgumentException
     */
    private function __construct(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException('Invalid email address: ' . $email);
        }

        $this->value = $email;
    }

    /**
     * @param string $email
     * @return static
     * @throws InvalidArgumentException
     */
    public static function create(string $email): self
    {
        return new static($email);
    }
}

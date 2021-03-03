<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

final class Uuid extends StringValueObject
{
    /**
     * Uuid constructor.
     * @param string $value
     * @throws InvalidArgumentException
     */
    private function __construct(string $value)
    {
        $this->ensureIsValidUuid($value);

        $this->value = $value;
    }

    /**
     * @param string $value
     * @return self
     * @throws InvalidArgumentException
     */
    public static function create(string $value): self
    {
        return new self($value);
    }

    /**
     * @return self
     * @throws InvalidArgumentException
     */
    public static function random(): self
    {
        return new self(RamseyUuid::uuid4()->toString());
    }

    /**
     * @param string $id
     * @throws InvalidArgumentException
     */
    private function ensureIsValidUuid(string $id): void
    {
        if (!RamseyUuid::isValid($id)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $id));
        }
    }
}

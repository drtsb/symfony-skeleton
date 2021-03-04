<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract class StringValueObject implements \Stringable
{
    protected string $value;

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equalsTo(self $other): bool
    {
        return $other instanceof static && $this->getValue() === $other->getValue();
    }
}

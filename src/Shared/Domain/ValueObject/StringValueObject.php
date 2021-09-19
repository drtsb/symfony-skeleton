<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use JetBrains\PhpStorm\Pure;

abstract class StringValueObject
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

    #[Pure]
    public function equalsTo(self $other): bool
    {
        return $this->getValue() === $other->getValue();
    }
}

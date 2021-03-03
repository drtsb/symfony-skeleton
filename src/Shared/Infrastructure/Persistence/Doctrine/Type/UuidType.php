<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Type;

use App\Shared\Domain\ValueObject\Uuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use InvalidArgumentException;

class UuidType extends GuidType
{
    public const NAME = 'uuid';

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return Uuid|mixed|null
     * @throws InvalidArgumentException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? Uuid::create($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Uuid ? $value->getValue() : $value;
    }
}

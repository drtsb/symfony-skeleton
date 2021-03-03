<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Persistence\Doctrine\Mapping\User;

use App\User\Domain\Aggregate\User\UserRole;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;
use InvalidArgumentException;
use JsonException;

final class UserRolesType extends JsonType
{
    public const NAME = 'user_user_roles';

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed|null
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $roles = json_decode($value, false, 512, JSON_THROW_ON_ERROR);
        $userRoles = [];
        foreach ($roles as $role) {
            $userRoles[] = UserRole::create($role);
        }
        return $userRoles;
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return string
     * @throws JsonException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return json_encode($value, JSON_THROW_ON_ERROR);
    }
}

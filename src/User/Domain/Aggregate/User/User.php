<?php

declare(strict_types=1);

namespace App\User\Domain\Aggregate\User;

use App\User\Domain\Event\User\UserBannedEvent;
use App\User\Domain\Event\User\UserUnbannedEvent;
use App\Shared\Domain\Entity\AggregateRoot;
use App\Shared\Domain\ValueObject\Uuid;
use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;

final class User extends AggregateRoot
{
    private Uuid $id;

    private DateTimeInterface $createdAt;

    private UserEmail $email;

    private UserPasswordHash $passwordHash;

    private UserStatus $status;

    /** @var UserRole[] */
    private array $roles = [];

    private ?DateTimeInterface $lastLoginTime = null;

    private function __construct(
        Uuid $id,
        DateTimeImmutable $createdAt,
        UserEmail $email,
        UserPasswordHash $passwordHash,
        UserStatus $status,
        ?DateTimeImmutable $lastLoginTime = null
    ) {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->status = $status;
        $this->lastLoginTime = $lastLoginTime;
    }

    /**
     * @param UserEmail $email
     * @param UserPasswordHash $passwordHash
     * @return User
     * @throws InvalidArgumentException
     */
    public static function create(
        UserEmail $email,
        UserPasswordHash $passwordHash
    ): self {
        return new self(
            Uuid::random(),
            new DateTimeImmutable(),
            $email,
            $passwordHash,
            UserStatus::active()
        );
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getEmail(): UserEmail
    {
        return $this->email;
    }

    /**
     * @param UserEmail $email
     * @return User
     */
    public function setEmail(UserEmail $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPasswordHash(): UserPasswordHash
    {
        return $this->passwordHash;
    }

    /**
     * @return UserStatus
     */
    public function getStatus(): UserStatus
    {
        return $this->status;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     * @return User
     * @throws InvalidArgumentException
     */
    public function setRoles(array $roles): self
    {
        $this->roles = [];
        foreach ($roles as $role) {
            $this->assign($role instanceof UserRole ? $role : UserRole::create($role));
        }
        return $this;
    }

    public function getLastLoginTime(): ?DateTimeInterface
    {
        return $this->lastLoginTime;
    }

    /**
     * @param DateTimeImmutable|null $lastLoginTime
     * @return User
     */
    public function setLastLoginTime(?DateTimeImmutable $lastLoginTime): User
    {
        $this->lastLoginTime = $lastLoginTime;
        return $this;
    }

    public function ban(): void
    {
        $this->status = UserStatus::banned();
        $this->registerEvent(UserBannedEvent::create($this));
    }

    public function unban(): void
    {
        $this->status = UserStatus::active();
        $this->registerEvent(UserUnbannedEvent::create($this));
    }

    public function isBanned(): bool
    {
        return $this->status->equalsTo(UserStatus::banned());
    }

    public function isActive(): bool
    {
        return $this->status->equalsTo(UserStatus::active());
    }

    public function assign(UserRole $role): void
    {
        foreach ($this->roles as $existingRole) {
            if ($role->equalsTo($existingRole)) {
                return;
            }
        }

        $this->roles[] = $role;
    }
}

<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Security;

use App\Shared\Infrastructure\Adapter\User\Dto\UserAuthenticationDto;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class User implements UserInterface
{
    private UuidInterface $id;

    private string $email;

    private string $passwordHash;

    private array $roles;

    private function __construct(
        UuidInterface $id,
        string $email,
        string $passwordHash,
        array $roles
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->roles = $roles;
    }

    public static function createFromDto(UserAuthenticationDto $dto): self
    {
        return new self(
            $dto->id,
            $dto->email,
            $dto->passwordHash,
            $dto->roles
        );
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPassword(): string
    {
        return $this->passwordHash;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }
}

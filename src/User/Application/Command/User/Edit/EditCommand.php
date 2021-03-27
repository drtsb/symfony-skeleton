<?php

declare(strict_types=1);

namespace App\User\Application\Command\User\Edit;

use App\User\Domain\Aggregate\User\User;
use App\User\Domain\Aggregate\User\UserRole;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Constraints as Assert;

final class EditCommand
{
    #[Assert\NotBlank]
    public string $id;

    #[Assert\Email]
    public string $email;

    #[Assert\Choice(choices: UserRole::VALUES, multiple: true)]
    public array $roles;

    #[Pure]
    public static function createFromUser(User $user): self
    {
        $command = new self();
        $command->id = $user->getId()->getValue();
        $command->email = $user->getEmail()->getValue();
        $command->roles = $user->getRoles();
        return $command;
    }
}

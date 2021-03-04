<?php

declare(strict_types=1);

namespace App\User\Application\User\Command\Edit;

use App\User\Domain\Aggregate\User\User;
use Symfony\Component\Validator\Constraints as Assert;

final class EditCommand
{
    /**
     * @Assert\NotBlank()
     */
    public string $id;

    #[\Symfony\Component\Validator\Constraints\Email]
    public string $email;

    /**
     * @Assert\Choice(choices=App\User\Domain\Aggregate\User\UserRole::VALUES, multiple=true)
     */
    public array $roles;

    public static function createFromUser(User $user): self
    {
        $command = new self();
        $command->id = $user->getId()->getValue();
        $command->email = $user->getEmail()->getValue();
        $command->roles = $user->getRoles();
        return $command;
    }
}

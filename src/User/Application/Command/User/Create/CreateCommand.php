<?php

declare(strict_types=1);

namespace App\User\Application\Command\User\Create;

use App\User\Domain\Aggregate\User\UserRole;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateCommand
{
    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank]
    public string $password;

    #[Assert\Choice(choices: UserRole::VALUES, multiple: true)]
    public array $roles;
}

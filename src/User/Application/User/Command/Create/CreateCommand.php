<?php

declare(strict_types=1);

namespace App\User\Application\User\Command\Create;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateCommand
{
    #[\Symfony\Component\Validator\Constraints\Email]
    public string $email;

    /**
     * @Assert\NotBlank()
     */
    public string $password;

    /**
     * @Assert\Choice(choices=App\User\Domain\Aggregate\User\UserRole::VALUES, multiple=true)
     */
    public array $roles;
}

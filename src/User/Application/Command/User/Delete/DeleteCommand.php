<?php

declare(strict_types=1);

namespace App\User\Application\Command\User\Delete;

use Symfony\Component\Validator\Constraints as Assert;

final class DeleteCommand
{
    #[Assert\NotBlank]
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}

<?php

declare(strict_types=1);

namespace App\User\Application\User\Command\Unban;

use Symfony\Component\Validator\Constraints as Assert;

final class UnbanCommand
{
    private function __construct(
        /**
         * @Assert\NotBlank()
         */
        private string $id
    )
    {
    }

    public static function create(string $id): self
    {
        return new self($id);
    }

    public function getId(): string
    {
        return $this->id;
    }
}

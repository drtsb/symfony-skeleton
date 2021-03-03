<?php

declare(strict_types=1);

namespace App\User\Application\User\Command\Ban;

use Symfony\Component\Validator\Constraints as Assert;

final class BanCommand
{
    /**
     * @Assert\NotBlank()
     */
    private string $id;

    private function __construct(string $id)
    {
        $this->id = $id;
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

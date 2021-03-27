<?php

declare(strict_types=1);

namespace App\User\Application\Query\User\Show;

use Symfony\Component\Validator\Constraints as Assert;

final class ShowQuery
{
    #[Assert\NotBlank]
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}

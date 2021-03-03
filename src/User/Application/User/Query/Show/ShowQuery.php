<?php

declare(strict_types=1);

namespace App\User\Application\User\Query\Show;

use Symfony\Component\Validator\Constraints as Assert;

final class ShowQuery
{
    /**
     * @Assert\NotBlank()
     */
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}

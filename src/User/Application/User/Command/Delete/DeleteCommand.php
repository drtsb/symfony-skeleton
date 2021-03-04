<?php

declare(strict_types=1);

namespace App\User\Application\User\Command\Delete;

use Symfony\Component\Validator\Constraints as Assert;

final class DeleteCommand
{
    public function __construct(
        /**
         * @Assert\NotBlank()
         */
        public string $id
    )
    {
    }
}

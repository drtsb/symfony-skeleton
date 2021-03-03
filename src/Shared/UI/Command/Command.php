<?php

declare(strict_types=1);

namespace App\Shared\UI\Command;

use Symfony\Component\Console\Command\Command as SymfonyCommand;

abstract class Command extends SymfonyCommand
{
    public const EXIT_CODE_OK = 0;
    public const EXIT_CODE_ERROR = 1;

    protected int $returnCode = self::EXIT_CODE_OK;
}

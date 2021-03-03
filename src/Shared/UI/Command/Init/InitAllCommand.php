<?php

declare(strict_types=1);

namespace App\Shared\UI\Command\Init;

use App\Shared\UI\Command\Command;
use Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class InitAllCommand extends Command
{
    public const COMMAND_NAME = 'app:init:all';

    private iterable $initCommands;

    public function __construct(iterable $initCommands)
    {
        $this->initCommands = $initCommands;
        parent::__construct(self::COMMAND_NAME);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->initCommands as $command) {
            $command->run($input, $output);
        }

        return $this->returnCode;
    }
}

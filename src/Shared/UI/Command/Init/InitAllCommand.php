<?php

declare(strict_types=1);

namespace App\Shared\UI\Command\Init;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class InitAllCommand extends Command
{
    protected static $defaultName = 'app:init:all';

    public function __construct(private iterable $initCommands)
    {
        parent::__construct();
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

        return self::SUCCESS;
    }
}

<?php

declare(strict_types=1);

namespace App\Shared\UI\Command\Init;

use App\Shared\Application\Initializer\InitializerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

abstract class InitCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $this->getInitializer()->init();
            $io->success(sprintf('%s initialization successfully completed.', $this->getTitle()));
        } catch (Throwable $exception) {
            $io->error(sprintf('Failed to initialize %s: %s', $this->getTitle(), $exception->getMessage()));
            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    abstract protected function getTitle(): string;

    abstract protected function getInitializer(): InitializerInterface;
}

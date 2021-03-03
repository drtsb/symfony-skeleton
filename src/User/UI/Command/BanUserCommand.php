<?php

declare(strict_types=1);

namespace App\User\UI\Command;

use App\User\Application\User\Command\Ban\BanCommand;
use App\Shared\UI\Command\Command;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class BanUserCommand extends Command
{
    public const COMMAND_NAME = 'app:user:ban';

    private const ARGUMENT_ID = 'id';

    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        parent::__construct(self::COMMAND_NAME);
        $this->commandBus = $commandBus;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Bans a user.')
            ->setHelp('This command allows you to ban a user...')
            ->addArgument(
                self::ARGUMENT_ID,
                InputArgument::REQUIRED,
                'User ID'
            )
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $id = $input->getArgument(self::ARGUMENT_ID);

            if (!Uuid::isValid($id)) {
                throw new \InvalidArgumentException(sprintf('`%s` is not a valid uuid.', $id));
            }

            $this->commandBus->dispatch(BanCommand::create($id));

            $io->success(sprintf('User `%s` successfully banned.', $id));
        } catch (Throwable $exception) {
            $io->error('Failed to ban user: ' . $exception->getMessage());
        }

        return $this->returnCode;
    }
}
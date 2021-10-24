<?php

declare(strict_types=1);

namespace App\User\UI\Command;

use App\User\Application\Command\User\Delete\DeleteCommand;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class DeleteUserCommand extends Command
{
    private const ARGUMENT_ID = 'id';

    protected static $defaultName = 'app:user:delete';

    public function __construct(private MessageBusInterface $commandBus)
    {
        parent::__construct();
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Deletes a user.')
            ->setHelp('This command allows you to delete a user...')
            ->addArgument(
                self::ARGUMENT_ID,
                InputArgument::REQUIRED,
                'User ID',
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

            $this->commandBus->dispatch(new DeleteCommand($id));

            $io->success(sprintf('User `%s` successfully deleted.', $id));
        } catch (Throwable $exception) {
            $io->error('Failed to delete user: ' . $exception->getMessage());
        }

        return self::SUCCESS;
    }
}
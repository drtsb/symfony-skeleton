<?php

declare(strict_types=1);

namespace App\User\UI\Command;

use App\User\Application\Command\User\Unban\UnbanCommand;
use App\Shared\UI\Command\Command;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class UnbanUserCommand extends Command
{
    public const COMMAND_NAME = 'app:user:unban';

    private const ARGUMENT_ID = 'id';

    public function __construct(private MessageBusInterface $commandBus)
    {
        parent::__construct(self::COMMAND_NAME);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Unbans a user.')
            ->setHelp('This command allows you to unban a user...')
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

            $this->commandBus->dispatch(UnbanCommand::create($id));

            $io->success(sprintf('User `%s` successfully unbanned.', $id));
        } catch (Throwable $exception) {
            $io->error('Failed to unban user: ' . $exception->getMessage());
        }

        return $this->returnCode;
    }
}

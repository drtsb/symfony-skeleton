<?php

declare(strict_types=1);

namespace App\User\UI\Command;

use App\User\Application\Command\User\Create\CreateCommand;
use App\User\Domain\Aggregate\User\UserRole;
use App\Shared\UI\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class CreateUserCommand extends Command
{
    public const COMMAND_NAME = 'app:user:create';

    public function __construct(private MessageBusInterface $commandBus)
    {
        parent::__construct(self::COMMAND_NAME);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        try {
            $command = new CreateCommand();

            $command->email = (string)$helper->ask($input, $output, new Question('Please enter the email: '));
            $command->password = (string)$helper->ask(
                $input,
                $output,
                (new Question('Please enter the password: '))->setHidden(true)
            );
            $command->roles = (array)$helper->ask(
                $input,
                $output,
                (new ChoiceQuestion(
                    sprintf('Please select user roles (defaults to %s): ', UserRole::ROLE_USER),
                    UserRole::VALUES,
                    '1'
                ))->setMultiselect(true)
            );

            $this->commandBus->dispatch($command);

            $io->success(sprintf('User `%s` successfully created.', $command->email));
        } catch (Throwable $exception) {
            $io->error('Failed to create user: ' . $exception->getMessage());
        }

        return $this->returnCode;
    }
}

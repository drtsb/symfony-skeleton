<?php

declare(strict_types=1);

namespace App\User\UI\Command;

use App\User\Domain\Aggregate\User\User;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\UI\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ListUsersCommand extends Command
{
    public const COMMAND_NAME = 'app:user:list';

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        parent::__construct(self::COMMAND_NAME);
        $this->userRepository = $userRepository;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Lists all existing users.')
            ->setHelp('This command allows you to list all existing users...')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->userRepository->findAll();

        $rows = [];

        /** @var User $user */
        foreach ($users as $user) {
            /** @noinspection JsonEncodingApiUsageInspection */
            $rows[] = [
                $user->getId()->getValue(),
                $user->getEmail()->getValue(),
                json_encode($user->getRoles()),
                $user->getStatus()->getValue(),
            ];
        }

        $table = new Table($output);
        $table
            ->setHeaderTitle('Users')
            ->setHeaders(['ID', 'Email', 'Roles', 'Status'])
            ->setRows($rows)
        ;
        $table->render();

        return $this->returnCode;
    }
}

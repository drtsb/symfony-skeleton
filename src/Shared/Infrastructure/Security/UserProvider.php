<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Security;

use App\Shared\Infrastructure\Adapter\User\UserAdapterInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserProvider implements UserProviderInterface
{
    public function __construct(private UserAdapterInterface $userAdapter)
    {
    }

    /**
     * @param string $username
     * @return UserInterface
     * @throws UsernameNotFoundException
     */
    public function loadUserByUsername(string $username): UserInterface
    {
        $userDto = $this->userAdapter->findUserForAuthentication($username);
        if ($userDto === null) {
            throw new UsernameNotFoundException(sprintf('User with email `%s` not found.', $username));
        }

        return User::createFromDto($userDto);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', $user::class));
        }

        return $user;
    }

    public function supportsClass(string $class): bool
    {
        // TODO: Implement supportsClass() method.
        return true;
    }
}

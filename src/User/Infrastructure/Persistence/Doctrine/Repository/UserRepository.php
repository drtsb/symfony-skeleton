<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Persistence\Doctrine\Repository;

use App\User\Domain\Aggregate\User\User;
use App\User\Domain\Aggregate\User\UserStatus;
use App\User\Domain\Exception\User\UserAlreadyExistsException;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\Domain\Exception\EntityNotAddedException;
use App\Shared\Domain\Exception\EntityNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;
use LogicException;
use Throwable;

final class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     * @param ManagerRegistry $registry
     * @throws LogicException
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function findAllActiveUsers(): array
    {
        return $this->findBy(['status.value' => UserStatus::ACTIVE,]);
    }

    public function findActiveUserByEmail(string $email): ?User
    {
        /** @var User $user */
        $user = $this->findOneBy(['email.value' => $email, 'status.value' => UserStatus::ACTIVE,]);

        return $user;
    }

    /**
     * @param string $id
     * @return User
     * @throws EntityNotFoundException
     */
    public function getById(string $id): User
    {
        $user = $this->find($id);
        if ($user === null || !$user instanceof User) {
            throw new EntityNotFoundException(sprintf('Unable to find user with ID %s.', $id));
        }

        return $user;
    }

    /**
     * @param string $email
     * @return User
     * @throws EntityNotFoundException
     */
    public function getByEmail(string $email): User
    {
        $user = $this->findOneBy(['email.value' => $email,]);
        if ($user === null || !$user instanceof User) {
            throw new EntityNotFoundException(sprintf('Unable to find user with email `%s`.', $email));
        }

        return $user;
    }

    /**
     * @param User $user
     * @throws EntityNotAddedException
     * @throws UserAlreadyExistsException
     */
    public function add(User $user): void
    {
        try {
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();
        } catch (UniqueConstraintViolationException $exception) {
            throw new UserAlreadyExistsException(
                sprintf('User with email `%s` already exists.', $user->getEmail()->getValue())
            );
        } catch (Throwable $exception) {
            throw new EntityNotAddedException($exception->getMessage());
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event\User;

use App\Shared\Domain\Event\DomainEventInterface;
use DateTimeImmutable;

final class UserLoggedInEvent implements DomainEventInterface
{
    private const DATE_FORMAT = 'Y-m-d H:i:s';

    private string $email;

    private string $time;

    private function __construct(string $email, string $time)
    {
        $this->email = $email;
        $this->time = $time;
    }

    public static function create(string $email, DateTimeImmutable $time): self
    {
        return new self($email, $time->format(self::DATE_FORMAT));
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getTime(): string
    {
        return $this->time;
    }
}

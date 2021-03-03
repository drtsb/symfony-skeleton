<?php

declare(strict_types=1);

namespace App\Shared\Domain\Entity;

use App\Shared\Domain\Event\DomainEventInterface;

abstract class AggregateRoot
{
    /** @var DomainEventInterface[] */
    protected array $events = [];

    final public function registerEvent(DomainEventInterface $event): void
    {
        $this->events[] = $event;
    }

    /**
     * @return DomainEventInterface[]
     */
    final public function releaseEvents(): array
    {
        $events       = $this->events;
        $this->events = [];

        return $events;
    }
}

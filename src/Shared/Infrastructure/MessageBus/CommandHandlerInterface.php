<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\MessageBus;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

interface CommandHandlerInterface extends MessageHandlerInterface
{

}

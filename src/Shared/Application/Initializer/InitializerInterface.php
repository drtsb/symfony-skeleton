<?php

declare(strict_types=1);

namespace App\Shared\Application\Initializer;

use InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

interface InitializerInterface
{
    /**
     * @throws InvalidArgumentException
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     */
    public function init(): void;
}

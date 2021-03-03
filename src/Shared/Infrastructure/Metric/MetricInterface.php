<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Metric;

use Exception;

interface MetricInterface
{
    public function getNamespace(): string;

    public function getName(): string;

    public function getHelp(): string;

    /**
     * @return float
     * @throws Exception
     */
    public function getValue(): float;

    public function getLabels(): array;
}

<?php

declare(strict_types=1);

namespace App\Shared\Application\Service\Metric;

interface MetricsServiceInterface
{
    public function getMetrics(): string;
}

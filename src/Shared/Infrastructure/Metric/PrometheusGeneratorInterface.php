<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Metric;

use Exception;
use Prometheus\CollectorRegistry;
use Prometheus\Exception\MetricsRegistrationException;

interface PrometheusGeneratorInterface
{
    /**
     * @param CollectorRegistry $registry
     * @throws MetricsRegistrationException
     * @throws Exception
     */
    public function generate(CollectorRegistry $registry): void;
}

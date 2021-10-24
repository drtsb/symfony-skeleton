<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Metric;

use Exception;
use Prometheus\CollectorRegistry;
use Prometheus\Exception\MetricsRegistrationException;

final class PrometheusGenerator implements PrometheusGeneratorInterface
{
    public function __construct(private iterable $metrics)
    {
    }

    /**
     * @param CollectorRegistry $registry
     * @throws MetricsRegistrationException
     * @throws Exception
     */
    public function generate(CollectorRegistry $registry): void
    {
        foreach ($this->metrics as $metric) {
            $gauge = $registry->getOrRegisterGauge(
                $metric->getNamespace(),
                $metric->getName(),
                $metric->getHelp(),
            );
            $gauge->set($metric->getValue(), $metric->getLabels());
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Shared\Application\Service\Metric;

use App\Shared\Infrastructure\Metric\PrometheusGeneratorInterface;
use Exception;
use Prometheus\CollectorRegistry;
use Prometheus\Exception\MetricsRegistrationException;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\InMemory;

final class PrometheusMetricsService implements PrometheusMetricsServiceInterface
{
    private CollectorRegistry $registry;

    private RenderTextFormat $renderer;

    private PrometheusGeneratorInterface $generator;

    public function __construct(PrometheusGeneratorInterface $generator)
    {
        $this->registry = new CollectorRegistry(new InMemory());
        $this->renderer = new RenderTextFormat();

        $this->generator = $generator;
    }

    /**
     * @return string
     * @throws MetricsRegistrationException
     */
    public function getMetrics(): string
    {
        return $this->render();
    }

    /**
     * @return string
     * @throws MetricsRegistrationException
     * @throws Exception
     */
    private function render(): string
    {
        $this->generator->generate($this->registry);
        return $this->renderer->render($this->registry->getMetricFamilySamples());
    }
}

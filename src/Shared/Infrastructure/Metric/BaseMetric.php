<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Metric;

abstract class BaseMetric
{
    public const UNITS_TOTAL = 'total';

    protected const NAMESPACE = 'symfony';

    public function getNamespace(): string
    {
        return static::NAMESPACE;
    }

    public function getName(): string
    {
        return $this->getMetricName() . '_' . $this->getUnits();
    }

    abstract protected function getMetricName(): string;

    abstract public function getHelp(): string;

    public function getLabels(): array
    {
        return [];
    }

    protected function getUnits(): string
    {
        return self::UNITS_TOTAL;
    }
}

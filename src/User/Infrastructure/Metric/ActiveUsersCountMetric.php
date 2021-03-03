<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Metric;

use App\Shared\Infrastructure\Metric\BaseMetric;
use App\Shared\Infrastructure\Metric\MetricInterface;

final class ActiveUsersCountMetric extends BaseMetric implements MetricInterface
{
    public function getValue(): float
    {
        return (float)mt_rand();
    }

    protected function getMetricName(): string
    {
        return 'active_users_count';
    }

    public function getHelp(): string
    {
        return 'Total Count of Active Users.';
    }
}

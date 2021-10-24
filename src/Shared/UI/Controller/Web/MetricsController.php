<?php

declare(strict_types=1);

namespace App\Shared\UI\Controller\Web;

use App\Shared\Application\Service\Metric\PrometheusMetricsServiceInterface;
use InvalidArgumentException;
use Prometheus\RenderTextFormat;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

final class MetricsController extends AbstractController
{
    protected const LOG_CATEGORY = 'metrics';

    public function __construct(
        private PrometheusMetricsServiceInterface $prometheusMetricsService,
        private LoggerInterface $logger,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    #[Route('/metrics/prometheus', name: 'metrics.prometheus')]
    public function prometheus(): Response
    {
        $response = new Response('', Response::HTTP_OK, ['Content-type' => RenderTextFormat::MIME_TYPE]);
        try {
            $response->setContent($this->prometheusMetricsService->getMetrics());
        } catch (Throwable $exception) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $this->logger->error(
                $exception->getMessage(),
                [
                    'statusCode' => $response->getStatusCode(),
                    'category'   => static::LOG_CATEGORY,
                    'trace'      => $exception->getTraceAsString(),
                ],
            );
        }
        return $response;
    }
}

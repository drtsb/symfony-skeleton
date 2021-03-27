<?php

declare(strict_types=1);

namespace App\Shared\UI\Controller\Web\Check;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class HealthController extends AbstractController
{
    #[Route('/check/health', name: 'check.health')]
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(
            [
                'application' => 'ok',
            ]
        );
    }
}

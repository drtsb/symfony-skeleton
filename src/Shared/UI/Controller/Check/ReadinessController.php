<?php

declare(strict_types=1);

namespace App\Shared\UI\Controller\Check;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ReadinessController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @todo Add redis and rmq checks
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/check/readiness', name: 'check.readiness')]
    public function __invoke(Request $request): JsonResponse
    {
        $connection = $this->entityManager->getConnection();
        $connection->connect();
        $dbIsReady = $connection->isConnected();

        return new JsonResponse(
            [
                'database' => $dbIsReady,
            ],
            $dbIsReady ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR,
        );
    }
}

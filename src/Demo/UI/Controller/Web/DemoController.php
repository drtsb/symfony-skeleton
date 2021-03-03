<?php

declare(strict_types=1);

namespace App\Demo\UI\Controller\Web;

use App\Demo\Infrastructure\Adapter\User\UserAdapterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DemoController extends AbstractController
{
    #[Route('/demo/users', name: 'demo.users')]
    public function __invoke(UserAdapterInterface $userAdapter): Response
    {
        return $this->render(
            'demo/demo/users.html.twig',
            [
                'users' => $userAdapter->findActiveUsers(),
            ]
        );
    }
}

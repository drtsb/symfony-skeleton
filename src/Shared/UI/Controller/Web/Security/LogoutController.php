<?php

declare(strict_types=1);

namespace App\Shared\UI\Controller\Web\Security;

use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class LogoutController extends AbstractController
{
    /**
     * @throws LogicException
     */
    #[Route('/security/logout', name: 'security.logout')]
    public function __invoke(): void
    {
        throw new LogicException(
            'This method can be blank - it will be intercepted by the logout key on your firewall.',
        );
    }
}

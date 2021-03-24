<?php

declare(strict_types=1);

namespace App\User\UI\Controller\Web\User;

use App\User\Application\Command\User\Unban\UnbanCommand;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class UnbanController extends AbstractController
{
    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    /**
     * @param string $id
     * @param Request $request
     * @return Response
     * @throws LogicException
     */
    #[Route('/user/{id}/unban', name: 'user.unban', methods: ['POST'])]
    public function unban(string $id, Request $request): Response
    {
        if ($this->isCsrfTokenValid('unban' . $id, $request->request->get('_token'))) {
            $this->commandBus->dispatch(UnbanCommand::create($id));
        }

        return $this->redirectToRoute('user.index');
    }
}
